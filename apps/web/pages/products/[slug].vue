<script setup lang="ts">
import type { ApiEnvelope, ProductDetail } from '~/types/api'

const api = useApiClient()
const basket = useBasket()
const route = useRoute()

const slug = computed(() => route.params.slug as string)
const feedback = ref('')
const actionError = ref('')
const submitting = ref(false)

const { data, error, pending, refresh } = await useAsyncData(
  () => `product-${slug.value}`,
  () => api<ApiEnvelope<ProductDetail>>(`/products/${slug.value}`),
  {
    watch: [slug],
  },
)

async function addToBasket() {
  if (!data.value) {
    return
  }

  submitting.value = true
  actionError.value = ''
  feedback.value = ''

  try {
    const result = await basket.addItem(data.value.data.id, 1)
    feedback.value = `Added to basket. Items now: ${result.positions}.`
  } catch (requestError) {
    actionError.value = getApiErrorMessage(requestError, 'Failed to add product to basket.')
  } finally {
    submitting.value = false
  }
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">Product</span>
    <h1>{{ data?.data.name || 'Loading product' }}</h1>
    <p>
      Product detail now has a dedicated route over the API contract and can add directly into the
      shared basket state.
    </p>

    <div class="hero__actions">
      <NuxtLink v-if="data?.data.category" class="button button--ghost" :to="`/catalog/category/${data.data.category.slug}`">
        Back to category
      </NuxtLink>
      <NuxtLink class="button button--accent" to="/basket">
        Open basket
      </NuxtLink>
    </div>
  </section>

  <section class="section">
    <div v-if="actionError" class="status status--error">
      {{ actionError }}
    </div>
    <div v-else-if="feedback" class="status status--success">
      {{ feedback }}
    </div>

    <div v-if="error" class="status status--error">
      {{ getApiErrorMessage(error, 'Failed to load product.') }}
    </div>
    <div v-else-if="pending" class="card">
      Loading product...
    </div>
    <template v-else-if="data">
      <div class="split">
        <article class="card stack">
          <div class="pill-row">
            <span v-if="data.data.flags.new" class="pill">new</span>
            <span v-if="data.data.flags.hit" class="pill">hit</span>
            <span v-if="data.data.flags.sale" class="pill">sale</span>
          </div>

          <div class="stack">
            <span class="eyebrow">Description</span>
            <p>{{ data.data.content || 'No product description yet.' }}</p>
          </div>

          <div class="actions">
            <button
              class="button button--accent"
              data-testid="product-detail-add-button"
              type="button"
              :disabled="submitting"
              @click="addToBasket"
            >
              {{ submitting ? 'Adding...' : 'Add to basket' }}
            </button>
            <button class="button button--ghost" type="button" @click="refresh()">
              Refresh
            </button>
          </div>
        </article>

        <aside class="card stack">
          <div>
            <span class="eyebrow">Meta</span>
            <h2>{{ data.data.name }}</h2>
          </div>

          <div class="metric-row">
            <div class="metric">
              <span class="muted">Price</span>
              <strong>{{ data.data.price }}</strong>
            </div>
          </div>

          <div class="pill-row">
            <NuxtLink v-if="data.data.brand" class="pill" :to="`/brands/${data.data.brand.slug}`">
              {{ data.data.brand.name }}
            </NuxtLink>
            <NuxtLink v-if="data.data.category" class="pill" :to="`/catalog/category/${data.data.category.slug}`">
              {{ data.data.category.name }}
            </NuxtLink>
          </div>
        </aside>
      </div>
    </template>
  </section>
</template>
