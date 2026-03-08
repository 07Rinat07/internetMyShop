<script setup lang="ts">
import type { CategoryProductsPayload, PaginatedEnvelope } from '~/types/api'

const api = useApiClient()
const basket = useBasket()
const route = useRoute()

const slug = computed(() => route.params.slug as string)
const page = computed(() => {
  const current = Number(route.query.page || 1)

  return Number.isNaN(current) || current < 1 ? 1 : current
})

const feedback = ref('')
const actionError = ref('')
const activeProductId = ref<number | null>(null)

const { data, error, pending, refresh } = await useAsyncData(
  () => `category-${slug.value}-${page.value}`,
  () => api<PaginatedEnvelope<CategoryProductsPayload>>(`/categories/${slug.value}?page=${page.value}`),
  {
    watch: [slug, page],
  },
)

async function addToBasket(productId: number) {
  activeProductId.value = productId
  actionError.value = ''
  feedback.value = ''

  try {
    const result = await basket.addItem(productId, 1)
    feedback.value = `Added to basket. Items now: ${result.positions}.`
  } catch (requestError) {
    actionError.value = getApiErrorMessage(requestError, 'Failed to add product to basket.')
  } finally {
    activeProductId.value = null
  }
}

async function goToPage(nextPage: number) {
  await navigateTo({
    path: route.path,
    query: nextPage > 1 ? { page: String(nextPage) } : {},
  })
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">Category</span>
    <h1>{{ data?.data.category.name || 'Loading category' }}</h1>
    <p>
      This route already reads the paginated category API and can add products into the shared
      basket state used by the separate frontend shell.
    </p>

    <div class="hero__actions">
      <NuxtLink class="button button--ghost" to="/catalog">
        Back to catalog
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
      {{ getApiErrorMessage(error, 'Failed to load category.') }}
    </div>
    <div v-else-if="pending" class="card">
      Loading products...
    </div>
    <template v-else-if="data">
      <div class="section__header">
        <div>
          <span class="eyebrow">Products</span>
          <h2>{{ data.meta.total }} items available</h2>
        </div>
        <button class="button button--ghost" type="button" @click="refresh()">
          Refresh
        </button>
      </div>

      <div v-if="!data.data.products.length" class="empty-state">
        <p>No products are published in this category yet.</p>
      </div>
      <div v-else class="grid grid--thirds">
        <article
          v-for="product in data.data.products"
          :key="product.id"
          class="card stack"
        >
          <div class="pill-row">
            <span v-if="product.flags.new" class="pill">new</span>
            <span v-if="product.flags.hit" class="pill">hit</span>
            <span v-if="product.flags.sale" class="pill">sale</span>
          </div>

          <div class="stack">
            <h3>{{ product.name }}</h3>
            <p class="muted mono">slug: {{ product.slug }}</p>
            <p v-if="product.brand">{{ product.brand.name }}</p>
          </div>

          <div class="metric-row">
            <div class="metric">
              <span class="muted">Price</span>
              <strong>{{ product.price }}</strong>
            </div>
          </div>

          <div class="actions">
            <button
              class="button button--accent"
              type="button"
              :disabled="activeProductId === product.id"
              @click="addToBasket(product.id)"
            >
              {{ activeProductId === product.id ? 'Adding...' : 'Add to basket' }}
            </button>
          </div>
        </article>
      </div>

      <div class="section section__header">
        <div>
          <span class="eyebrow">Pagination</span>
          <h2>Page {{ data.meta.current_page }} of {{ data.meta.last_page }}</h2>
        </div>
        <div class="actions">
          <button
            class="button button--ghost"
            type="button"
            :disabled="data.meta.current_page <= 1"
            @click="goToPage(data.meta.current_page - 1)"
          >
            Previous
          </button>
          <button
            class="button button--ghost"
            type="button"
            :disabled="data.meta.current_page >= data.meta.last_page"
            @click="goToPage(data.meta.current_page + 1)"
          >
            Next
          </button>
        </div>
      </div>
    </template>
  </section>
</template>
