import { describe, expect, it } from 'vitest'
import type { AuthUser, CheckoutPayload, Profile } from '../../types/api'
import {
  applyProfileToCheckout,
  createEmptyCheckoutPayload,
  prefillCheckoutFromUser,
} from '../../utils/checkout'

describe('checkout utils', () => {
  it('creates an empty checkout payload', () => {
    expect(createEmptyCheckoutPayload()).toEqual({
      name: '',
      email: '',
      phone: '',
      address: '',
      comment: '',
      payment_method: 'online_card',
    })
  })

  it('prefills name and email from the authenticated user', () => {
    const payload: CheckoutPayload = {
      name: '',
      email: '',
      phone: '+7 111 111 1111',
      address: 'Existing address',
      comment: 'Keep this note',
      payment_method: 'manager_confirmation',
    }
    const user: AuthUser = {
      id: 1,
      name: 'E2E Buyer',
      email: 'buyer@example.test',
      admin: false,
      created_at: null,
      updated_at: null,
    }

    expect(prefillCheckoutFromUser(payload, user)).toEqual({
      name: 'E2E Buyer',
      email: 'buyer@example.test',
      phone: '+7 111 111 1111',
      address: 'Existing address',
      comment: 'Keep this note',
      payment_method: 'manager_confirmation',
    })
  })

  it('keeps the payload unchanged when no user is available', () => {
    const payload: CheckoutPayload = {
      name: 'Guest',
      email: 'guest@example.test',
      phone: '+7 222 222 2222',
      address: 'Guest street',
      comment: '',
      payment_method: 'online_card',
    }

    expect(prefillCheckoutFromUser(payload, null)).toEqual(payload)
  })

  it('applies the selected profile to the checkout form', () => {
    const payload: CheckoutPayload = {
      name: '',
      email: '',
      phone: '',
      address: '',
      comment: '',
      payment_method: 'online_card',
    }
    const profile: Profile = {
      id: 5,
      title: 'Primary checkout profile',
      name: 'E2E Buyer',
      email: 'buyer@example.test',
      phone: '+7 700 000 0000',
      address: '123 Test Street, Demo City',
      comment: 'Leave at the front desk.',
    }

    expect(applyProfileToCheckout(payload, profile)).toEqual({
      name: 'E2E Buyer',
      email: 'buyer@example.test',
      phone: '+7 700 000 0000',
      address: '123 Test Street, Demo City',
      comment: 'Leave at the front desk.',
      payment_method: 'online_card',
    })
  })
})
