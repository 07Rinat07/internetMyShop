<script setup lang="ts">
const basket = useBasket()

const feedback = ref('')
const errorMessage = ref('')
const ready = ref(false)
const activeProductId = ref<number | null>(null)
const clearing = ref(false)

onMounted(async () => {
  try {
    await basket.load(true)
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, 'Failed to load basket.')
  } finally {
    ready.value = true
  }
})

async function updateQuantity(productId: number, quantity: number) {
  activeProductId.value = productId
  feedback.value = ''
  errorMessage.value = ''

  try {
    await basket.updateItem(productId, quantity)
    feedback.value = 'Basket updated.'
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, 'Failed to update basket item.')
  } finally {
    activeProductId.value = null
  }
}

async function removeItem(productId: number) {
  activeProductId.value = productId
  feedback.value = ''
  errorMessage.value = ''

  try {
    await basket.removeItem(productId)
    feedback.value = 'Item removed.'
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, 'Failed to remove basket item.')
  } finally {
    activeProductId.value = null
  }
}

async function clearBasket() {
  clearing.value = true
  feedback.value = ''
  errorMessage.value = ''

  try {
    await basket.clear()
    feedback.value = 'Basket cleared.'
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, 'Failed to clear basket.')
  } finally {
    clearing.value = false
  }
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">Basket</span>
    <h1>Cookie-based basket is now managed from the Nuxt frontend.</h1>
    <p>
      The shared basket composable talks to <span class="mono">/api/v1/basket*</span> and keeps
      the same server-side basket contract the legacy storefront used.
    </p>

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
  </section>

  <section class="section">
    <div v-if="errorMessage" class="status status--error">
      {{ errorMessage }}
    </div>
    <div v-else-if="feedback" class="status status--success">
      {{ feedback }}
    </div>

    <div v-if="!ready" class="card">
      Loading basket...
    </div>
    <template v-else>
      <div class="section__header">
        <div>
          <span class="eyebrow">Current basket</span>
          <h2>{{ basket.positions.value }} active positions</h2>
        </div>
        <div class="actions">
          <NuxtLink class="button button--ghost" to="/catalog">
            Continue shopping
          </NuxtLink>
          <button
            class="button button--danger"
            type="button"
            :disabled="basket.isEmpty.value || clearing"
            @click="clearBasket"
          >
            {{ clearing ? 'Clearing...' : 'Clear basket' }}
          </button>
        </div>
      </div>

      <div v-if="basket.isEmpty.value" class="empty-state">
        <p>Your basket is empty. Browse a category and add products first.</p>
      </div>
      <div v-else class="split">
        <div class="list">
          <article
            v-for="item in basket.basket.value.items"
            :key="item.product_id"
            class="list-item"
          >
            <div class="list-item__header">
              <div>
                <strong>{{ item.name }}</strong>
                <p class="muted mono">{{ item.slug }}</p>
              </div>
              <button
                class="button button--danger"
                type="button"
                :disabled="activeProductId === item.product_id"
                @click="removeItem(item.product_id)"
              >
                {{ activeProductId === item.product_id ? 'Removing...' : 'Remove' }}
              </button>
            </div>

            <div class="pill-row">
              <span class="pill">Price: {{ item.price }}</span>
              <span class="pill">Cost: {{ item.cost }}</span>
              <span v-if="item.brand" class="pill">{{ item.brand.name }}</span>
            </div>

            <div class="actions">
              <button
                class="button button--ghost"
                type="button"
                :disabled="activeProductId === item.product_id || item.quantity <= 1"
                @click="updateQuantity(item.product_id, item.quantity - 1)"
              >
                -
              </button>
              <span class="pill">Qty: {{ item.quantity }}</span>
              <button
                class="button button--ghost"
                type="button"
                :disabled="activeProductId === item.product_id"
                @click="updateQuantity(item.product_id, item.quantity + 1)"
              >
                +
              </button>
            </div>
          </article>
        </div>

        <aside class="card stack">
          <div>
            <span class="eyebrow">Summary</span>
            <h2>Checkout-ready basket</h2>
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

          <NuxtLink class="button button--accent" to="/checkout">
            Go to checkout
          </NuxtLink>
        </aside>
      </div>
    </template>
  </section>
</template>
