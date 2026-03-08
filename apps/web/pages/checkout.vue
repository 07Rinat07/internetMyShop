<script setup lang="ts">
import type { CheckoutPayload, OrderDetail, Profile } from '~/types/api'

const api = useApiClient()
const auth = useAuth()
const basket = useBasket()

const ready = ref(false)
const loadingProfiles = ref(false)
const profileError = ref('')
const feedback = ref('')
const errorMessage = ref('')
const submitting = ref(false)
const completedOrder = ref<OrderDetail | null>(null)
const savedProfiles = ref<Profile[]>([])

const form = reactive<CheckoutPayload>({
  name: '',
  email: '',
  phone: '',
  address: '',
  comment: '',
})

onMounted(async () => {
  try {
    if (auth.token.value && !auth.user.value) {
      await auth.ensureUser()
    }

    await basket.load(true)

    if (auth.user.value) {
      form.name = auth.user.value.name
      form.email = auth.user.value.email
      await loadProfiles()
    }
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, 'Failed to prepare checkout.')
  } finally {
    ready.value = true
  }
})

async function loadProfiles() {
  loadingProfiles.value = true
  profileError.value = ''

  try {
    const response = await api<{ data: Profile[] }>('/profiles')
    savedProfiles.value = response.data
  } catch (error) {
    profileError.value = getApiErrorMessage(error, 'Failed to load saved profiles.')
  } finally {
    loadingProfiles.value = false
  }
}

function applyProfile(profile: Profile) {
  form.name = profile.name
  form.email = profile.email
  form.phone = profile.phone
  form.address = profile.address
  form.comment = profile.comment || ''
}

async function submitCheckout() {
  submitting.value = true
  feedback.value = ''
  errorMessage.value = ''

  try {
    completedOrder.value = await basket.checkout(form)
    feedback.value = 'Order created successfully.'
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, 'Checkout request failed.')
  } finally {
    submitting.value = false
  }
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">Checkout</span>
    <h1>Submit the order from the separate frontend.</h1>
    <p>
      This page posts directly to <span class="mono">/api/v1/basket/checkout</span>. If the user
      is signed in, the order is automatically attached to the Sanctum account.
    </p>
  </section>

  <section class="section">
    <div v-if="errorMessage" class="status status--error">
      {{ errorMessage }}
    </div>
    <div v-else-if="feedback" class="status status--success">
      {{ feedback }}
    </div>

    <div v-if="!ready" class="card">
      Preparing checkout...
    </div>
    <div v-else-if="basket.isEmpty.value && !completedOrder" class="empty-state">
      <p>Basket is empty. Add products before checkout.</p>
      <div class="actions">
        <NuxtLink class="button button--ghost" to="/catalog">
          Browse catalog
        </NuxtLink>
        <NuxtLink class="button button--accent" to="/basket">
          Open basket
        </NuxtLink>
      </div>
    </div>
    <template v-else>
      <div class="split">
        <article class="card stack">
          <div>
            <span class="eyebrow">Delivery form</span>
            <h2>Customer details</h2>
          </div>

          <div v-if="auth.user.value" class="card card--compact stack">
            <div class="section__header">
              <div>
                <span class="eyebrow">Saved profiles</span>
                <h2>Prefill from account</h2>
              </div>
            </div>

            <div v-if="profileError" class="status status--error">
              {{ profileError }}
            </div>
            <div v-else-if="loadingProfiles" class="muted">
              Loading saved profiles...
            </div>
            <div v-else-if="savedProfiles.length" class="list">
              <article
                v-for="profile in savedProfiles"
                :key="profile.id"
                class="list-item"
              >
                <div class="list-item__header">
                  <div>
                    <strong>{{ profile.title }}</strong>
                    <p>{{ profile.address }}</p>
                  </div>
                  <button class="button button--ghost" type="button" @click="applyProfile(profile)">
                    Use profile
                  </button>
                </div>
              </article>
            </div>
            <div v-else class="empty-state">
              <p>No saved profiles yet. Fill the form manually or create one in Profile.</p>
            </div>
          </div>

          <form class="form-grid" @submit.prevent="submitCheckout">
            <div class="form-grid form-grid--two">
              <div class="field">
                <label for="checkout-name">Name</label>
                <input id="checkout-name" v-model="form.name" class="input" required>
              </div>
              <div class="field">
                <label for="checkout-email">Email</label>
                <input id="checkout-email" v-model="form.email" class="input" type="email" required>
              </div>
            </div>

            <div class="field">
              <label for="checkout-phone">Phone</label>
              <input id="checkout-phone" v-model="form.phone" class="input" required>
            </div>

            <div class="field">
              <label for="checkout-address">Address</label>
              <textarea id="checkout-address" v-model="form.address" class="textarea" required></textarea>
            </div>

            <div class="field">
              <label for="checkout-comment">Comment</label>
              <textarea id="checkout-comment" v-model="form.comment" class="textarea"></textarea>
            </div>

            <button class="button button--accent" type="submit" :disabled="submitting || basket.isEmpty.value">
              {{ submitting ? 'Submitting order...' : 'Place order' }}
            </button>
          </form>
        </article>

        <aside class="card stack">
          <div>
            <span class="eyebrow">Summary</span>
            <h2>Basket snapshot</h2>
          </div>

          <div class="metric-row">
            <div class="metric">
              <span class="muted">Positions</span>
              <strong>{{ basket.positions.value }}</strong>
            </div>
            <div class="metric">
              <span class="muted">Amount</span>
              <strong>{{ basket.amount.value }}</strong>
            </div>
          </div>

          <div class="list">
            <article
              v-for="item in basket.basket.value.items"
              :key="item.product_id"
              class="list-item"
            >
              <div class="list-item__header">
                <strong>{{ item.name }}</strong>
                <span class="pill">x{{ item.quantity }}</span>
              </div>
              <div class="pill-row">
                <span class="pill">Price: {{ item.price }}</span>
                <span class="pill">Cost: {{ item.cost }}</span>
              </div>
            </article>
          </div>

          <NuxtLink class="button button--ghost" to="/basket">
            Back to basket
          </NuxtLink>
        </aside>
      </div>

      <section v-if="completedOrder" class="section">
        <article class="card card--accent stack">
          <span class="eyebrow">Order created</span>
          <h2>Order #{{ completedOrder.id }}</h2>
          <div class="pill-row">
            <span class="pill">Amount: {{ completedOrder.amount }}</span>
            <span class="pill">{{ completedOrder.status.label || 'No status label' }}</span>
          </div>
          <p>
            The API returned the order payload immediately. If you were signed in, it is also now
            visible in the Orders page.
          </p>
          <div class="actions">
            <NuxtLink v-if="auth.user.value" class="button button--accent" to="/orders">
              View orders
            </NuxtLink>
            <NuxtLink class="button button--ghost" to="/catalog">
              Continue shopping
            </NuxtLink>
          </div>
        </article>
      </section>
    </template>
  </section>
</template>
