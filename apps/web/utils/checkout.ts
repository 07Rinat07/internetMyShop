import type { AuthUser, CheckoutPayload, Profile } from '~/types/api'

export function createEmptyCheckoutPayload(): CheckoutPayload {
  return {
    name: '',
    email: '',
    phone: '',
    address: '',
    comment: '',
    payment_method: 'online_card',
  }
}

export function prefillCheckoutFromUser(
  payload: CheckoutPayload,
  user: AuthUser | null,
): CheckoutPayload {
  if (!user) {
    return { ...payload }
  }

  return {
    ...payload,
    name: user.name || payload.name,
    email: user.email || payload.email,
  }
}

export function applyProfileToCheckout(
  payload: CheckoutPayload,
  profile: Profile,
): CheckoutPayload {
  return {
    ...payload,
    name: profile.name,
    email: profile.email,
    phone: profile.phone,
    address: profile.address,
    comment: profile.comment || '',
  }
}
