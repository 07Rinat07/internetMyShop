import type { ApiEnvelope, Basket, CheckoutPayload, CheckoutResponse } from '~/types/api'

const emptyBasket = (): Basket => ({
  id: 0,
  positions: 0,
  amount: 0,
  items: [],
})

export function useBasket() {
  const api = useApiClient()
  const basket = useState<Basket>('basket-state', emptyBasket)
  const initialized = useState<boolean>('basket-initialized', () => false)
  const pending = useState<boolean>('basket-pending', () => false)

  async function syncBasket(request: Promise<ApiEnvelope<Basket>>) {
    const response = await request
    basket.value = response.data
    initialized.value = true

    return response.data
  }

  async function load(force = false) {
    if (initialized.value && !force) {
      return basket.value
    }

    pending.value = true

    try {
      return await syncBasket(api<ApiEnvelope<Basket>>('/basket'))
    } finally {
      pending.value = false
    }
  }

  async function addItem(productId: number, quantity = 1) {
    return await syncBasket(api<ApiEnvelope<Basket>>('/basket/items', {
      method: 'POST',
      body: {
        product_id: productId,
        quantity,
      },
    }))
  }

  async function updateItem(productId: number, quantity: number) {
    return await syncBasket(api<ApiEnvelope<Basket>>(`/basket/items/${productId}`, {
      method: 'PATCH',
      body: {
        quantity,
      },
    }))
  }

  async function removeItem(productId: number) {
    return await syncBasket(api<ApiEnvelope<Basket>>(`/basket/items/${productId}`, {
      method: 'DELETE',
    }))
  }

  async function clear() {
    return await syncBasket(api<ApiEnvelope<Basket>>('/basket', {
      method: 'DELETE',
    }))
  }

  async function checkout(payload: CheckoutPayload) {
    pending.value = true

    try {
      const response = await api<ApiEnvelope<CheckoutResponse>>('/basket/checkout', {
        method: 'POST',
        body: payload,
      })

      basket.value = emptyBasket()
      initialized.value = true

      return response.data
    } finally {
      pending.value = false
    }
  }

  return {
    basket,
    initialized,
    pending,
    positions: computed(() => basket.value.positions),
    amount: computed(() => basket.value.amount),
    isEmpty: computed(() => basket.value.positions === 0),
    load,
    addItem,
    updateItem,
    removeItem,
    clear,
    checkout,
  }
}
