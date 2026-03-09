<script setup lang="ts">
const basket = useBasket()
const { t } = useLocale()

const feedback = ref('')
const errorMessage = ref('')
const ready = ref(false)
const activeProductId = ref<number | null>(null)
const clearing = ref(false)

onMounted(async () => {
  try {
    await basket.load(true)
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, t('basket_page.load_failed'))
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
    feedback.value = t('basket_page.updated')
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, t('basket_page.update_failed'))
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
    feedback.value = t('basket_page.removed')
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, t('basket_page.remove_failed'))
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
    feedback.value = t('basket_page.cleared')
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, t('basket_page.clear_failed'))
  } finally {
    clearing.value = false
  }
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">{{ t('basket_page.hero_eyebrow') }}</span>
    <h1>{{ t('basket_page.hero_title') }}</h1>
    <p>
      {{ t('basket_page.hero_description') }}
    </p>

    <div class="metric-row">
      <div class="metric">
        <span class="muted">{{ t('common.positions') }}</span>
        <strong>{{ basket.positions.value }}</strong>
      </div>
      <div class="metric">
        <span class="muted">{{ t('common.amount') }}</span>
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
      {{ t('basket_page.loading') }}
    </div>
    <template v-else>
      <div class="section__header">
        <div>
          <span class="eyebrow">{{ t('basket_page.current_basket') }}</span>
          <h2>{{ t('basket_page.active_positions', { count: basket.positions.value }) }}</h2>
        </div>
        <div class="actions">
          <NuxtLink class="button button--ghost" to="/catalog">
            {{ t('common.continue_shopping') }}
          </NuxtLink>
            <button
              class="button button--danger"
              type="button"
              :disabled="basket.isEmpty.value || clearing"
              @click="clearBasket"
          >
            {{ clearing ? t('common.clearing') : t('basket_page.clear_button') }}
          </button>
        </div>
      </div>

      <div v-if="basket.isEmpty.value" class="empty-state">
        <p>{{ t('basket_page.empty') }}</p>
      </div>
      <div v-else class="split">
        <div class="list">
          <article
            v-for="item in basket.basket.value.items"
            :key="item.product_id"
            class="list-item"
            data-testid="basket-item"
          >
            <div class="list-item__header">
              <div>
                <strong>{{ item.name }}</strong>
              </div>
              <button
                class="button button--danger"
                type="button"
                :disabled="activeProductId === item.product_id"
                @click="removeItem(item.product_id)"
              >
                {{ activeProductId === item.product_id ? t('common.loading') : t('common.remove') }}
              </button>
            </div>

            <div class="pill-row">
              <span class="pill">{{ t('common.price') }}: {{ item.price }}</span>
              <span class="pill">{{ t('common.cost') }}: {{ item.cost }}</span>
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
              <span class="pill">{{ t('common.quantity') }}: {{ item.quantity }}</span>
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
            <span class="eyebrow">{{ t('common.summary') }}</span>
            <h2>{{ t('basket_page.summary_title') }}</h2>
          </div>

          <div class="metric-row">
            <div class="metric">
              <span class="muted">{{ t('common.positions') }}</span>
              <strong>{{ basket.positions.value }}</strong>
            </div>
            <div class="metric">
              <span class="muted">{{ t('common.amount') }}</span>
              <strong>{{ basket.amount.value }}</strong>
            </div>
          </div>

          <NuxtLink class="button button--accent" data-testid="basket-checkout-link" to="/checkout">
            {{ t('basket_page.go_to_checkout') }}
          </NuxtLink>
        </aside>
      </div>
    </template>
  </section>
</template>
