<script setup lang="ts">
import type { ApiEnvelope, OrderDetail, OrderSummary, PaginatedResponse } from '~/types/api'

definePageMeta({
  middleware: 'auth',
})

const api = useApiClient()
const auth = useAuth()
const { orderStatusLabel, t } = useLocale()

await auth.ensureUser()

const { data, error, pending, refresh } = await useAsyncData('orders', () =>
  api<PaginatedResponse<OrderSummary>>('/orders'),
)

const selectedOrder = ref<OrderDetail | null>(null)
const selectedOrderId = ref<number | null>(null)
const detailError = ref('')
const detailPending = ref(false)

async function loadOrder(orderId: number) {
  detailPending.value = true
  detailError.value = ''

  try {
    const response = await api<ApiEnvelope<OrderDetail>>(`/orders/${orderId}`)
    selectedOrder.value = response.data
    selectedOrderId.value = orderId
  } catch (requestError) {
    detailError.value = getApiErrorMessage(requestError, t('orders.detail_failed'))
  } finally {
    detailPending.value = false
  }
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">{{ t('orders.hero_eyebrow') }}</span>
    <h1>{{ t('orders.hero_title') }}</h1>
    <p>
      {{ t('orders.hero_description') }}
    </p>

    <div class="metric-row">
      <div class="metric">
        <span class="muted">{{ t('orders.user') }}</span>
        <strong>{{ auth.user.value?.name || t('orders.unknown_user') }}</strong>
      </div>
      <div class="metric">
        <span class="muted">{{ t('orders.records') }}</span>
        <strong>{{ data?.meta.total || 0 }}</strong>
      </div>
    </div>
  </section>

  <section class="section split">
    <article class="card stack">
      <div class="section__header">
        <div>
          <span class="eyebrow">{{ t('orders.history') }}</span>
          <h2>{{ t('orders.your_orders') }}</h2>
        </div>
        <button class="button button--ghost" type="button" @click="refresh()">
          {{ t('common.refresh') }}
        </button>
      </div>

      <div v-if="error" class="status status--error">
        {{ getApiErrorMessage(error, t('orders.load_failed')) }}
      </div>
      <div v-else-if="pending" class="card card--compact">
        {{ t('orders.loading') }}
      </div>
      <div v-else-if="!data?.data.length" class="empty-state">
        <p>{{ t('orders.empty') }}</p>
      </div>
      <div v-else class="list">
        <article
          v-for="order in data.data"
          :key="order.id"
          class="list-item"
          data-testid="order-list-item"
        >
          <div class="list-item__header">
            <div>
              <strong>#{{ order.id }}</strong>
              <p>{{ orderStatusLabel(order.status.code, order.status.label) }}</p>
            </div>
            <button
              class="button"
              :class="selectedOrderId === order.id ? 'button--accent' : 'button--ghost'"
              data-testid="order-view-details"
              type="button"
              @click="loadOrder(order.id)"
            >
              {{ selectedOrderId === order.id ? t('orders.selected') : t('orders.view_details') }}
            </button>
          </div>

          <div class="pill-row">
            <span class="pill">{{ t('common.amount') }}: {{ order.amount }}</span>
            <span class="pill">{{ t('orders.items') }}: {{ order.items_count }}</span>
          </div>
          <p class="muted">{{ order.created_at || t('orders.no_timestamp') }}</p>
        </article>
      </div>
    </article>

    <article class="card stack" data-testid="order-detail">
      <div>
        <span class="eyebrow">{{ t('orders.detail') }}</span>
        <h2>{{ t('orders.selected_order') }}</h2>
      </div>

      <div v-if="detailError" class="status status--error">
        {{ detailError }}
      </div>
      <div v-else-if="detailPending" class="card card--compact">
        {{ t('orders.detail_loading') }}
      </div>
      <div v-else-if="!selectedOrder" class="empty-state">
        <p>{{ t('orders.choose_order') }}</p>
      </div>
      <template v-else>
        <div class="pill-row">
          <span class="pill">#{{ selectedOrder.id }}</span>
          <span class="pill">{{ orderStatusLabel(selectedOrder.status.code, selectedOrder.status.label) }}</span>
          <span class="pill">{{ t('common.amount') }}: {{ selectedOrder.amount }}</span>
        </div>

        <div class="stack">
          <strong>{{ selectedOrder.name }}</strong>
          <span class="mono">{{ selectedOrder.email }}</span>
          <span>{{ selectedOrder.phone }}</span>
          <span>{{ selectedOrder.address }}</span>
          <span v-if="selectedOrder.comment" class="muted">{{ selectedOrder.comment }}</span>
        </div>

        <div class="stack">
          <span class="eyebrow">{{ t('orders.items_heading') }}</span>
          <article
            v-for="item in selectedOrder.items"
            :key="item.id"
            class="list-item"
          >
            <div class="list-item__header">
              <strong>{{ item.name }}</strong>
              <span class="pill">x{{ item.quantity }}</span>
            </div>
            <div class="pill-row">
              <span class="pill">{{ t('common.price') }}: {{ item.price }}</span>
              <span class="pill">{{ t('common.cost') }}: {{ item.cost }}</span>
            </div>
          </article>
        </div>
      </template>
    </article>
  </section>
</template>
