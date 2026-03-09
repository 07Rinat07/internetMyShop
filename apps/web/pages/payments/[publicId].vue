<script setup lang="ts">
import type { ApiEnvelope, PaymentDetail } from '~/types/api'

const route = useRoute()
const auth = useAuth()
const api = useApiClient()
const {
  orderStatusLabel,
  paymentMethodLabel,
  paymentProviderLabel,
  paymentStatusLabel,
  t,
} = useLocale()

const publicId = computed(() => String(route.params.publicId || ''))

await auth.ensureUser()

const { data, error, pending, refresh } = await useAsyncData(
  () => `payment-${publicId.value}`,
  () => api<ApiEnvelope<PaymentDetail>>(`/payments/${publicId.value}`),
)

const payment = computed(() => data.value?.data ?? null)
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">{{ t('payments.hero_eyebrow') }}</span>
    <h1>{{ t('payments.hero_title') }}</h1>
    <p>
      {{ t('payments.hero_description') }}
    </p>
  </section>

  <section class="section">
    <div v-if="error" class="status status--error">
      {{ getApiErrorMessage(error, t('payments.load_failed')) }}
    </div>
    <div v-else-if="pending" class="card">
      {{ t('payments.checking') }}
    </div>
    <article v-else-if="payment" class="card stack" data-testid="payment-status-card">
      <div class="section__header">
        <div>
          <span class="eyebrow">{{ t('common.status') }}</span>
          <h2>{{ t('payments.result_title') }}</h2>
          <span>{{ t('payments.payment_number') }}: {{ payment.id }}</span>
        </div>
        <button class="button button--ghost" type="button" @click="refresh()">
          {{ t('common.refresh') }}
        </button>
      </div>

      <div class="pill-row">
        <span class="pill">{{ paymentStatusLabel(payment.status.code, payment.status.label) }}</span>
        <span class="pill">{{ payment.amount }} {{ payment.currency }}</span>
        <span class="pill">{{ t('payments.store_amount') }}: {{ payment.store_amount }} {{ payment.store_currency }}</span>
      </div>

      <div v-if="payment.failure_reason" class="status status--error">
        {{ payment.failure_reason }}
      </div>

      <p v-if="payment.status.code === 'succeeded'">
        {{ t('payments.succeeded') }}
      </p>
      <p v-else-if="payment.status.code === 'cancelled'">
        {{ t('payments.cancelled') }}
      </p>
      <p v-else-if="payment.status.code === 'failed'">
        {{ t('payments.failed') }}
      </p>
      <p v-else>
        {{ t('payments.pending') }}
      </p>

      <div v-if="payment.order" class="stack">
        <span class="eyebrow">{{ t('payments.order_title') }}</span>
        <strong>#{{ payment.order.id }}</strong>
        <span>{{ t('common.amount') }}: {{ payment.order.amount }} {{ payment.order.currency }}</span>
        <span>{{ t('common.method') }}: {{ paymentMethodLabel(payment.order.payment_method.code, payment.order.payment_method.label) }}</span>
        <span>{{ t('common.status') }}: {{ orderStatusLabel(payment.order.status.code, payment.order.status.label) }}</span>
      </div>

      <div class="actions">
        <NuxtLink v-if="auth.user.value" class="button button--accent" to="/orders">
          {{ t('payments.view_orders') }}
        </NuxtLink>
        <NuxtLink class="button button--ghost" to="/catalog">
          {{ t('common.continue_shopping') }}
        </NuxtLink>
      </div>
    </article>
  </section>
</template>
