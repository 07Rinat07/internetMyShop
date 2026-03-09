import {
  localeOptions,
  normalizeLocale,
  translate,
  translateOrderStatus,
  translatePaymentMethod,
  translatePaymentProvider,
  translatePaymentStatus,
  translateProductFlag,
  type TranslationKey,
} from '~/utils/locale'

export function useLocale() {
  const localeCookie = useCookie<string>('locale', {
    sameSite: 'lax',
    path: '/',
  })
  const locale = useState('locale', () => normalizeLocale(localeCookie.value))

  locale.value = normalizeLocale(locale.value || localeCookie.value)

  function setLocale(nextLocale: string) {
    const normalized = normalizeLocale(nextLocale)

    locale.value = normalized
    localeCookie.value = normalized
  }

  function t(key: TranslationKey, replacements?: Record<string, string | number>) {
    return translate(locale.value, key, replacements)
  }

  return {
    locale,
    localeOptions,
    setLocale,
    t,
    orderStatusLabel: (code: number | string, fallback?: string | null) =>
      translateOrderStatus(locale.value, code, fallback),
    paymentStatusLabel: (code: string, fallback?: string | null) =>
      translatePaymentStatus(locale.value, code, fallback),
    paymentMethodLabel: (code: string, fallback?: string | null) =>
      translatePaymentMethod(locale.value, code, fallback),
    paymentProviderLabel: (code: string, fallback?: string | null) =>
      translatePaymentProvider(locale.value, code, fallback),
    productFlagLabel: (code: string, fallback?: string | null) =>
      translateProductFlag(locale.value, code, fallback),
  }
}
