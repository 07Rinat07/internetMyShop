<script setup lang="ts">
import type { ApiEnvelope, ProductDetail } from '~/types/api'

const api = useApiClient()
const basket = useBasket()
const route = useRoute()
const { productFlagLabel, t } = useLocale()

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
    feedback.value = t('common.added_to_basket', { count: result.positions })
  } catch (requestError) {
    actionError.value = getApiErrorMessage(requestError, t('common.add_failed'))
  } finally {
    submitting.value = false
  }
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">{{ t('product_page.hero_eyebrow') }}</span>
    <h1>{{ data?.data.name || t('product_page.loading_title') }}</h1>
    <p>
      {{ t('product_page.hero_description') }}
    </p>

    <div class="hero__actions">
      <NuxtLink v-if="data?.data.category" class="button button--ghost" :to="`/catalog/category/${data.data.category.slug}`">
        {{ t('common.back_to_category') }}
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
      {{ getApiErrorMessage(error, t('product_page.load_failed')) }}
    </div>
    <div v-else-if="pending" class="card">
      {{ t('product_page.loading') }}
    </div>
    <template v-else-if="data">
      <div class="split">
        <article class="card stack">
          <div class="catalog-media catalog-media--detail">
            <img
              v-if="data.data.image"
              :src="data.data.image"
              :alt="data.data.name"
              class="catalog-media__image"
            >
            <div v-else class="catalog-media__placeholder" aria-hidden="true"></div>
          </div>

          <div class="pill-row">
            <span v-if="data.data.flags.new" class="pill">{{ productFlagLabel('new') }}</span>
            <span v-if="data.data.flags.hit" class="pill">{{ productFlagLabel('hit') }}</span>
            <span v-if="data.data.flags.sale" class="pill">{{ productFlagLabel('sale') }}</span>
          </div>

          <div class="stack">
            <span class="eyebrow">{{ t('common.description') }}</span>
            <p>{{ data.data.content || t('product_page.no_description') }}</p>
          </div>

          <div class="actions">
            <button
              class="button button--accent"
              data-testid="product-detail-add-button"
              type="button"
              :disabled="submitting"
              @click="addToBasket"
            >
              {{ submitting ? t('common.adding') : t('common.add_to_basket') }}
            </button>
            <button class="button button--ghost" type="button" @click="refresh()">
              {{ t('common.refresh') }}
            </button>
          </div>
        </article>

        <aside class="card stack">
          <div>
            <span class="eyebrow">{{ t('common.meta') }}</span>
            <h2>{{ data.data.name }}</h2>
          </div>

          <div class="metric-row">
            <div class="metric">
              <span class="muted">{{ t('common.price') }}</span>
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
