<script setup lang="ts">
import type { ApiEnvelope, OrderDetail, OrderSummary, PaginatedResponse } from '~/types/api'

definePageMeta({
  middleware: 'auth',
})

const api = useApiClient()
const auth = useAuth()

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
    detailError.value = getApiErrorMessage(requestError, 'Failed to load order details.')
  } finally {
    detailPending.value = false
  }
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">Orders</span>
    <h1>Order history is now available through protected API endpoints.</h1>
    <p>
      This page calls <span class="mono">/orders</span> for the current account and lazily loads
      detailed line items from <span class="mono">/orders/{id}</span>.
    </p>

    <div class="metric-row">
      <div class="metric">
        <span class="muted">User</span>
        <strong>{{ auth.user.value?.name || 'Unknown user' }}</strong>
      </div>
      <div class="metric">
        <span class="muted">Records</span>
        <strong>{{ data?.meta.total || 0 }}</strong>
      </div>
    </div>
  </section>

  <section class="section split">
    <article class="card stack">
      <div class="section__header">
        <div>
          <span class="eyebrow">History</span>
          <h2>Your orders</h2>
        </div>
        <button class="button button--ghost" type="button" @click="refresh()">
          Refresh
        </button>
      </div>

      <div v-if="error" class="status status--error">
        {{ getApiErrorMessage(error, 'Failed to load orders.') }}
      </div>
      <div v-else-if="pending" class="card card--compact">
        Loading orders...
      </div>
      <div v-else-if="!data?.data.length" class="empty-state">
        <p>No orders are attached to this account yet.</p>
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
              <p>{{ order.status.label || 'Unknown status' }}</p>
            </div>
            <button
              class="button"
              :class="selectedOrderId === order.id ? 'button--accent' : 'button--ghost'"
              data-testid="order-view-details"
              type="button"
              @click="loadOrder(order.id)"
            >
              {{ selectedOrderId === order.id ? 'Selected' : 'View details' }}
            </button>
          </div>

          <div class="pill-row">
            <span class="pill">Amount: {{ order.amount }}</span>
            <span class="pill">Items: {{ order.items_count }}</span>
          </div>
          <p class="muted">{{ order.created_at || 'No timestamp' }}</p>
        </article>
      </div>
    </article>

    <article class="card stack" data-testid="order-detail">
      <div>
        <span class="eyebrow">Detail</span>
        <h2>Selected order</h2>
      </div>

      <div v-if="detailError" class="status status--error">
        {{ detailError }}
      </div>
      <div v-else-if="detailPending" class="card card--compact">
        Loading order detail...
      </div>
      <div v-else-if="!selectedOrder" class="empty-state">
        <p>Choose an order from the left to inspect its items and delivery data.</p>
      </div>
      <template v-else>
        <div class="pill-row">
          <span class="pill">#{{ selectedOrder.id }}</span>
          <span class="pill">{{ selectedOrder.status.label || 'No label' }}</span>
          <span class="pill">Amount: {{ selectedOrder.amount }}</span>
        </div>

        <div class="stack">
          <strong>{{ selectedOrder.name }}</strong>
          <span class="mono">{{ selectedOrder.email }}</span>
          <span>{{ selectedOrder.phone }}</span>
          <span>{{ selectedOrder.address }}</span>
          <span v-if="selectedOrder.comment" class="muted">{{ selectedOrder.comment }}</span>
        </div>

        <div class="stack">
          <span class="eyebrow">Items</span>
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
              <span class="pill">Price: {{ item.price }}</span>
              <span class="pill">Cost: {{ item.cost }}</span>
              <span v-if="item.product" class="pill mono">
                {{ item.product.slug }}
              </span>
            </div>
          </article>
        </div>
      </template>
    </article>
  </section>
</template>
