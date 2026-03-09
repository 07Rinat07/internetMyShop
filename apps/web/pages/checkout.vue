<script setup lang="ts">
import type {
  ApiEnvelope,
  CheckoutResponse,
  PaymentCheckoutConfig,
  PaymentDetail,
  PaymentMethodCode,
  Profile,
} from '~/types/api'
import {
  applyProfileToCheckout,
  createEmptyCheckoutPayload,
  prefillCheckoutFromUser,
} from '~/utils/checkout'

type PayPalApprovePayload = {
  orderID?: string
  payerID?: string
}

type PayPalField = {
  render: (selector: string) => Promise<void> | void
}

type PayPalCardFieldsInstance = {
  isEligible: () => boolean
  submit: (options?: Record<string, unknown>) => Promise<void>
  NameField: () => PayPalField
  NumberField: () => PayPalField
  ExpiryField: () => PayPalField
  CVVField: () => PayPalField
}

type PayPalNamespace = {
  CardFields: (options: {
    createOrder: () => string | Promise<string>
    onApprove: (data: PayPalApprovePayload) => Promise<void> | void
    onError: (error: unknown) => Promise<void> | void
  }) => PayPalCardFieldsInstance
}

declare global {
  interface Window {
    paypal?: PayPalNamespace
  }
}

const api = useApiClient()
const auth = useAuth()
const basket = useBasket()
const {
  orderStatusLabel,
  paymentMethodLabel,
  paymentStatusLabel,
  t,
} = useLocale()

const ready = ref(false)
const loadingProfiles = ref(false)
const profileError = ref('')
const feedback = ref('')
const errorMessage = ref('')
const submitting = ref(false)
const paymentUiPending = ref(false)
const paymentUiReady = ref(false)
const paymentUiError = ref('')
const checkoutResult = ref<CheckoutResponse | null>(null)
const paymentConfig = ref<PaymentCheckoutConfig | null>(null)
const savedProfiles = ref<Profile[]>([])

const form = reactive(createEmptyCheckoutPayload())

let paypalCardFields: PayPalCardFieldsInstance | null = null

const hostedPayment = computed(() => checkoutResult.value?.payment ?? null)
const selectedPaymentMethod = computed<PaymentMethodCode>(() => form.payment_method)
const isOnlineCard = computed(() => selectedPaymentMethod.value === 'online_card')
const statusLink = computed(() => paymentConfig.value?.status_url ?? (hostedPayment.value ? `/payments/${hostedPayment.value.id}` : '/payments'))
const sandboxConversionNotice = computed(() => {
  const payment = hostedPayment.value

  if (!payment || payment.currency === payment.store_currency) {
    return ''
  }

  return t('checkout.sandbox_conversion_notice', {
    payment_amount: payment.amount,
    payment_currency: payment.currency,
    store_amount: payment.store_amount,
    store_currency: payment.store_currency,
    rate: payment.conversion_rate,
  })
})

onMounted(async () => {
  try {
    await auth.ensureUser()
    await basket.load(true)

    if (auth.user.value) {
      Object.assign(form, prefillCheckoutFromUser(form, auth.user.value))
      await loadProfiles()
    }
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, t('checkout.prepare_failed'))
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
    profileError.value = getApiErrorMessage(error, t('checkout.load_profiles_failed'))
  } finally {
    loadingProfiles.value = false
  }
}

function applyProfile(profile: Profile) {
  Object.assign(form, applyProfileToCheckout(form, profile))
}

function choosePaymentMethod(method: PaymentMethodCode) {
  form.payment_method = method
  if (checkoutResult.value) {
    resetCheckoutState()
  }
}

async function submitCheckout() {
  submitting.value = true
  feedback.value = ''
  errorMessage.value = ''
  paymentUiError.value = ''
  resetPaymentUi()

  try {
    checkoutResult.value = await basket.checkout(form)

    if (!checkoutResult.value.payment) {
      feedback.value = t('checkout.order_created_manual')
      return
    }

    feedback.value = t('checkout.order_created_online')
    await prepareHostedPayment(checkoutResult.value.payment.id)
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, t('checkout.request_failed'))
  } finally {
    submitting.value = false
  }
}

async function prepareHostedPayment(paymentId: string) {
  paymentUiPending.value = true
  paymentUiReady.value = false
  paymentUiError.value = ''

  try {
    const response = await api<ApiEnvelope<PaymentCheckoutConfig>>(`/payments/${paymentId}/checkout-config`)
    paymentConfig.value = response.data

    await nextTick()

    const providerCode = hostedPayment.value?.provider.code

    if (providerCode === 'paypal') {
      await mountPayPalFields(response.data)
    } else {
      paymentUiReady.value = true
    }
  } catch (error) {
    paymentUiError.value = getApiErrorMessage(error, t('checkout.payment_init_failed'))
  } finally {
    paymentUiPending.value = false
  }
}

async function mountPayPalFields(config: PaymentCheckoutConfig) {
  const sdk = config.sdk

  if (!sdk) {
    throw new Error(t('checkout.paypal_sdk_missing'))
  }

  await loadScript(sdk.script_url, {
    'data-client-token': sdk.client_token,
  })

  const paypal = window.paypal

  if (!paypal?.CardFields) {
    throw new Error(t('checkout.paypal_unavailable'))
  }

  clearPayPalContainers()

  const cardFields = paypal.CardFields({
    createOrder: () => config.provider_payment_id || '',
    onApprove: async (data) => {
      await captureHostedPayment(data.orderID || config.provider_payment_id || undefined, data.payerID)
    },
    onError: (error) => {
      paymentUiPending.value = false
      paymentUiError.value = error instanceof Error ? error.message : t('checkout.card_payment_failed')
    },
  })

  if (!cardFields.isEligible()) {
    throw new Error(t('checkout.paypal_not_eligible'))
  }

  await Promise.resolve(cardFields.NameField().render('#paypal-name-field'))
  await Promise.resolve(cardFields.NumberField().render('#paypal-number-field'))
  await Promise.resolve(cardFields.ExpiryField().render('#paypal-expiry-field'))
  await Promise.resolve(cardFields.CVVField().render('#paypal-cvv-field'))

  paypalCardFields = cardFields
  paymentUiReady.value = true
}

async function submitHostedPayment() {
  const payment = hostedPayment.value

  if (!payment || !paymentConfig.value) {
    return
  }

  paymentUiPending.value = true
  paymentUiError.value = ''

  try {
    if (payment.provider.code === 'paypal') {
      if (!paypalCardFields) {
        throw new Error(t('checkout.paypal_not_ready'))
      }

      await paypalCardFields.submit()
      return
    }

    if (payment.provider.code === 'fake') {
      await captureHostedPayment(paymentConfig.value.provider_payment_id || undefined)
      return
    }

    throw new Error(`Unsupported provider: ${payment.provider.code}`)
  } catch (error) {
    paymentUiPending.value = false
    paymentUiError.value = getApiErrorMessage(error, t('checkout.card_payment_failed'))
  }
}

async function captureHostedPayment(providerPaymentId?: string, payerId?: string) {
  const payment = hostedPayment.value

  if (!payment) {
    return
  }

  try {
    const response = await api<ApiEnvelope<PaymentDetail>>(`/payments/${payment.id}/capture`, {
      method: 'POST',
      body: {
        provider_payment_id: providerPaymentId,
        payer_id: payerId,
      },
    })

    if (checkoutResult.value) {
      checkoutResult.value = {
        ...checkoutResult.value,
        payment: response.data,
      }
    }

    feedback.value = response.data.status.code === 'succeeded'
      ? t('checkout.payment_confirmed')
      : t('checkout.payment_updated')

    if (process.client) {
      await navigateTo(`/payments/${response.data.id}`)
    }
  } catch (error) {
    paymentUiError.value = getApiErrorMessage(error, t('checkout.capture_failed'))
  } finally {
    paymentUiPending.value = false
  }
}

function resetCheckoutState() {
  checkoutResult.value = null
  feedback.value = ''
  errorMessage.value = ''
  resetPaymentUi()
}

function resetPaymentUi() {
  paypalCardFields = null
  paymentConfig.value = null
  paymentUiReady.value = false
  paymentUiPending.value = false
  paymentUiError.value = ''
  clearPayPalContainers()
}

function clearPayPalContainers() {
  if (!process.client) {
    return
  }

  for (const id of ['paypal-name-field', 'paypal-number-field', 'paypal-expiry-field', 'paypal-cvv-field']) {
    document.getElementById(id)?.replaceChildren()
  }
}

async function loadScript(src: string, attributes: Record<string, string>) {
  if (!process.client) {
    return
  }

  const existing = Array.from(document.scripts).find((script) => script.dataset.checkoutSdk === src)

  if (existing) {
    if (window.paypal) {
      return
    }

    await new Promise<void>((resolve, reject) => {
      existing.addEventListener('load', () => resolve(), { once: true })
      existing.addEventListener('error', () => reject(new Error(t('checkout.sdk_load_failed'))), { once: true })
    })

    return
  }

  await new Promise<void>((resolve, reject) => {
    const script = document.createElement('script')
    script.src = src
    script.async = true
    script.dataset.checkoutSdk = src

    for (const [key, value] of Object.entries(attributes)) {
      script.setAttribute(key, value)
    }

    script.addEventListener('load', () => resolve(), { once: true })
    script.addEventListener('error', () => reject(new Error(t('checkout.sdk_load_failed'))), { once: true })
    document.head.append(script)
  })
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">{{ t('checkout.hero_eyebrow') }}</span>
    <h1>{{ t('checkout.hero_title') }}</h1>
    <p>
      {{ t('checkout.hero_description') }}
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
      {{ t('checkout.preparing') }}
    </div>
    <div v-else-if="basket.isEmpty.value && !checkoutResult" class="empty-state">
      <p>{{ t('checkout.empty') }}</p>
      <div class="actions">
        <NuxtLink class="button button--ghost" to="/catalog">
          {{ t('checkout.browse_catalog') }}
        </NuxtLink>
        <NuxtLink class="button button--accent" to="/basket">
          {{ t('checkout.open_basket') }}
        </NuxtLink>
      </div>
    </div>
    <template v-else>
      <div class="split">
        <article class="card stack">
          <div>
            <span class="eyebrow">{{ t('checkout.delivery_form') }}</span>
            <h2>{{ t('checkout.customer_details') }}</h2>
          </div>

          <div v-if="auth.user.value" class="card card--compact stack">
            <div class="section__header">
              <div>
                <span class="eyebrow">{{ t('checkout.saved_profiles') }}</span>
                <h2>{{ t('checkout.prefill_from_account') }}</h2>
              </div>
            </div>

            <div v-if="profileError" class="status status--error">
              {{ profileError }}
            </div>
            <div v-else-if="loadingProfiles" class="muted">
              {{ t('checkout.loading_saved_profiles') }}
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
                  <button
                    class="button button--ghost"
                    data-testid="saved-profile-use"
                    type="button"
                    @click="applyProfile(profile)"
                  >
                    {{ t('checkout.use_profile') }}
                  </button>
                </div>
              </article>
            </div>
            <div v-else class="empty-state">
              <p>{{ t('checkout.no_saved_profiles') }}</p>
            </div>
          </div>

          <form class="form-grid" @submit.prevent="submitCheckout">
            <div class="form-grid form-grid--two">
              <div class="field">
                <label for="checkout-name">{{ t('checkout.name') }}</label>
                <input id="checkout-name" v-model="form.name" class="input" required>
              </div>
              <div class="field">
                <label for="checkout-email">{{ t('checkout.email') }}</label>
                <input id="checkout-email" v-model="form.email" class="input" type="email" required>
              </div>
            </div>

            <div class="field">
              <label for="checkout-phone">{{ t('checkout.phone') }}</label>
              <input id="checkout-phone" v-model="form.phone" class="input" required>
            </div>

            <div class="field">
              <label for="checkout-address">{{ t('checkout.address') }}</label>
              <textarea id="checkout-address" v-model="form.address" class="textarea" required></textarea>
            </div>

            <div class="field">
              <label for="checkout-comment">{{ t('checkout.comment') }}</label>
              <textarea id="checkout-comment" v-model="form.comment" class="textarea"></textarea>
            </div>

            <div class="field">
              <label>{{ t('checkout.payment_method') }}</label>
              <p class="muted">{{ t('checkout.payment_method_hint') }}</p>
              <div class="payment-methods">
                <button
                  class="payment-method"
                  :class="{ 'payment-method--active': selectedPaymentMethod === 'online_card' }"
                  data-testid="checkout-payment-online_card"
                  type="button"
                  @click="choosePaymentMethod('online_card')"
                >
                  <strong>{{ t('checkout.online_card_title') }}</strong>
                  <span>{{ t('checkout.online_card_description') }}</span>
                </button>
                <button
                  class="payment-method"
                  :class="{ 'payment-method--active': selectedPaymentMethod === 'manager_confirmation' }"
                  data-testid="checkout-payment-manager_confirmation"
                  type="button"
                  @click="choosePaymentMethod('manager_confirmation')"
                >
                  <strong>{{ t('checkout.manager_confirmation_title') }}</strong>
                  <span>{{ t('checkout.manager_confirmation_description') }}</span>
                </button>
              </div>
            </div>

            <button
              class="button button--accent"
              data-testid="checkout-submit"
              type="submit"
              :disabled="submitting || basket.isEmpty.value"
            >
              {{ submitting ? t('checkout.submit_processing') : (isOnlineCard ? t('checkout.submit_online') : t('checkout.submit_manual')) }}
            </button>
          </form>
        </article>

        <aside class="card stack">
          <div>
            <span class="eyebrow">{{ t('checkout.summary') }}</span>
            <h2>{{ t('checkout.basket_snapshot') }}</h2>
          </div>

          <div class="metric-row">
            <div class="metric">
              <span class="muted">{{ t('common.positions') }}</span>
              <strong>{{ basket.positions.value }}</strong>
            </div>
            <div class="metric">
              <span class="muted">{{ t('common.amount') }}</span>
              <strong>{{ basket.amount.value }} KZT</strong>
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
                <span class="pill">{{ t('common.price') }}: {{ item.price }} KZT</span>
                <span class="pill">{{ t('common.cost') }}: {{ item.cost }} KZT</span>
              </div>
            </article>
          </div>

          <NuxtLink class="button button--ghost" to="/basket">
            {{ t('checkout.back_to_basket') }}
          </NuxtLink>
        </aside>
      </div>

      <section v-if="checkoutResult" class="section">
        <article class="card card--accent stack" data-testid="checkout-success">
          <span class="eyebrow">{{ t('checkout.created') }}</span>
          <h2>{{ t('common.order') }} #{{ checkoutResult.order.id }}</h2>
          <div class="pill-row">
            <span class="pill">{{ t('common.order') }}: {{ checkoutResult.order.amount }} {{ checkoutResult.order.currency }}</span>
            <span class="pill">{{ paymentMethodLabel(checkoutResult.order.payment_method.code, checkoutResult.order.payment_method.label) }}</span>
            <span class="pill">{{ orderStatusLabel(checkoutResult.order.status.code, checkoutResult.order.status.label) }}</span>
            <span v-if="checkoutResult.payment" class="pill">
              {{ paymentStatusLabel(checkoutResult.payment.status.code, checkoutResult.payment.status.label) }}
            </span>
          </div>

          <p v-if="!checkoutResult.payment">
            {{ t('checkout.manual_order_message') }}
          </p>
          <template v-else>
            <p v-if="sandboxConversionNotice">
              {{ sandboxConversionNotice }}
            </p>

            <div v-if="paymentUiError" class="status status--error">
              {{ paymentUiError }}
            </div>
            <div v-else-if="paymentUiPending" class="status">
              {{ t('checkout.payment_pending') }}
            </div>

            <div v-if="checkoutResult.payment.provider.code === 'paypal'" class="stack">
              <div class="hosted-grid">
                <div class="field">
                  <label>{{ t('checkout.name_on_card') }}</label>
                  <div id="paypal-name-field" class="hosted-field"></div>
                </div>
                <div class="field hosted-grid__full">
                  <label>{{ t('checkout.card_number') }}</label>
                  <div id="paypal-number-field" class="hosted-field"></div>
                </div>
                <div class="field">
                  <label>{{ t('checkout.expiry') }}</label>
                  <div id="paypal-expiry-field" class="hosted-field"></div>
                </div>
                <div class="field">
                  <label>{{ t('checkout.cvv') }}</label>
                  <div id="paypal-cvv-field" class="hosted-field"></div>
                </div>
              </div>
            </div>

            <div v-else-if="checkoutResult.payment.provider.code === 'fake' && paymentConfig?.sandbox_card" class="stack">
              <div class="fake-card">
                <div class="fake-card__row">
                  <span>{{ t('checkout.sandbox_card') }}</span>
                  <strong>{{ paymentConfig.sandbox_card.number }}</strong>
                </div>
                <div class="fake-card__meta">
                  <span>{{ t('checkout.expiry') }} {{ paymentConfig.sandbox_card.expiry }}</span>
                  <span>{{ t('checkout.cvv') }} {{ paymentConfig.sandbox_card.cvv }}</span>
                  <span>{{ t('checkout.postal_code') }} {{ paymentConfig.sandbox_card.postal_code }}</span>
                </div>
              </div>
            </div>

            <div class="actions">
              <button
                class="button button--accent"
                data-testid="checkout-card-submit"
                type="button"
                :disabled="paymentUiPending || !paymentUiReady"
                @click="submitHostedPayment"
              >
                {{ paymentUiPending ? t('common.loading') : t('checkout.pay_now') }}
              </button>
              <a class="button button--ghost" :href="statusLink">
                {{ t('checkout.open_payment_status') }}
              </a>
            </div>
          </template>
        </article>
      </section>
    </template>
  </section>
</template>
