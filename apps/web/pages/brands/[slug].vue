<script setup lang="ts">
import type { BrandProductsPayload, PaginatedEnvelope } from '~/types/api'
import { normalizePositivePage } from '~/utils/pagination'

const api = useApiClient()
const basket = useBasket()
const route = useRoute()
const { productFlagLabel, t } = useLocale()

const slug = computed(() => route.params.slug as string)
const page = computed(() => normalizePositivePage(route.query.page))

const feedback = ref('')
const actionError = ref('')
const activeProductId = ref<number | null>(null)

const { data, error, pending, refresh } = await useAsyncData(
  () => `brand-${slug.value}-${page.value}`,
  () => api<PaginatedEnvelope<BrandProductsPayload>>(`/brands/${slug.value}?page=${page.value}`),
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
    feedback.value = t('common.added_to_basket', { count: result.positions })
  } catch (requestError) {
    actionError.value = getApiErrorMessage(requestError, t('common.add_failed'))
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
    <span class="hero__eyebrow">{{ t('brand_page.hero_eyebrow') }}</span>
    <h1>{{ data?.data.brand.name || t('brand_page.loading_title') }}</h1>
    <p>
      {{ t('brand_page.hero_description') }}
    </p>

    <div class="hero__actions">
      <NuxtLink class="button button--ghost" to="/catalog">
        {{ t('common.back_to_catalog') }}
      </NuxtLink>
      <NuxtLink class="button button--accent" to="/basket">
        {{ t('common.open_basket') }}
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
      {{ getApiErrorMessage(error, t('brand_page.load_failed')) }}
    </div>
    <div v-else-if="pending" class="card">
      {{ t('brand_page.loading') }}
    </div>
    <template v-else-if="data">
      <div class="section__header">
        <div>
          <span class="eyebrow">{{ t('common.products') }}</span>
          <h2>{{ t('brand_page.products_title', { count: data.meta.total }) }}</h2>
        </div>
        <button class="button button--ghost" type="button" @click="refresh()">
          {{ t('common.refresh') }}
        </button>
      </div>

      <div class="card card--accent stack">
        <span class="eyebrow">{{ t('brand_page.note') }}</span>
        <p>{{ data.data.brand.content || t('brand_page.no_description') }}</p>
      </div>

      <div v-if="!data.data.products.length" class="empty-state section">
        <p>{{ t('brand_page.empty') }}</p>
      </div>
      <div v-else class="grid grid--thirds section">
        <article
          v-for="product in data.data.products"
          :key="product.id"
          class="card stack"
        >
          <NuxtLink class="catalog-media catalog-media--product" :to="`/products/${product.slug}`">
            <img
              v-if="product.image"
              :src="product.image"
              :alt="product.name"
              class="catalog-media__image"
              loading="lazy"
            >
            <div v-else class="catalog-media__placeholder" aria-hidden="true"></div>
          </NuxtLink>

          <div class="pill-row">
            <span v-if="product.flags.new" class="pill">{{ productFlagLabel('new') }}</span>
            <span v-if="product.flags.hit" class="pill">{{ productFlagLabel('hit') }}</span>
            <span v-if="product.flags.sale" class="pill">{{ productFlagLabel('sale') }}</span>
          </div>

          <div class="stack">
            <h3>
              <NuxtLink :to="`/products/${product.slug}`">
                {{ product.name }}
              </NuxtLink>
            </h3>
            <p v-if="product.category">
              <NuxtLink :to="`/catalog/category/${product.category.slug}`">
                {{ product.category.name }}
              </NuxtLink>
            </p>
          </div>

          <div class="metric-row">
            <div class="metric">
              <span class="muted">{{ t('common.price') }}</span>
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
              {{ activeProductId === product.id ? t('common.adding') : t('common.add_to_basket') }}
            </button>
          </div>
        </article>
      </div>

      <div class="section section__header">
        <div>
          <span class="eyebrow">{{ t('common.pagination') }}</span>
          <h2>{{ t('common.page_of', { current: data.meta.current_page, last: data.meta.last_page }) }}</h2>
        </div>
        <div class="actions">
          <button
            class="button button--ghost"
            type="button"
            :disabled="data.meta.current_page <= 1"
            @click="goToPage(data.meta.current_page - 1)"
          >
            {{ t('common.previous') }}
          </button>
          <button
            class="button button--ghost"
            type="button"
            :disabled="data.meta.current_page >= data.meta.last_page"
            @click="goToPage(data.meta.current_page + 1)"
          >
            {{ t('common.next') }}
          </button>
        </div>
      </div>
    </template>
  </section>
</template>
