<script setup lang="ts">
import type { ApiEnvelope, HomePayload } from '~/types/api'

const api = useApiClient()
const auth = useAuth()
const basket = useBasket()
const { productFlagLabel, t } = useLocale()

const feedback = ref('')
const actionError = ref('')
const activeProductId = ref<number | null>(null)

const { data, error, pending, refresh } = await useAsyncData('storefront-home', () =>
  api<ApiEnvelope<HomePayload>>('/home'),
)

const sections = computed(() => ([
  { id: 'home-new', title: t('home.section_new'), items: data.value?.data.new ?? [] },
  { id: 'home-hit', title: t('home.section_hit'), items: data.value?.data.hit ?? [] },
  { id: 'home-sale', title: t('home.section_sale'), items: data.value?.data.sale ?? [] },
]).filter((section) => section.items.length > 0))

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
</script>

<template>
  <section class="store-hero">
    <div class="store-hero__content">
      <span class="hero__eyebrow">{{ t('home.hero_eyebrow') }}</span>
      <h1 class="store-hero__title">{{ t('home.hero_title') }}</h1>
      <p class="store-hero__description">
        {{ t('home.hero_description') }}
      </p>

      <div class="hero__actions">
        <NuxtLink class="button button--accent" to="/catalog">
          {{ t('home.primary_cta') }}
        </NuxtLink>
        <a
          v-if="(data?.data.hit.length || 0) > 0"
          class="button button--ghost"
          href="#home-hit"
        >
          {{ t('home.secondary_cta') }}
        </a>
        <NuxtLink
          v-else-if="auth.loggedIn.value"
          class="button button--ghost"
          to="/profile"
        >
          {{ t('home.go_to_profile') }}
        </NuxtLink>
        <NuxtLink
          v-else
          class="button button--ghost"
          to="/login"
        >
          {{ t('home.login_or_register') }}
        </NuxtLink>
      </div>
    </div>

    <div class="store-hero__stats">
      <div class="hero-stat">
        <strong>{{ data?.data.new.length || 0 }}</strong>
        <span>{{ t('home.section_new') }}</span>
      </div>
      <div class="hero-stat">
        <strong>{{ data?.data.hit.length || 0 }}</strong>
        <span>{{ t('home.section_hit') }}</span>
      </div>
      <div class="hero-stat">
        <strong>{{ data?.data.sale.length || 0 }}</strong>
        <span>{{ t('home.section_sale') }}</span>
      </div>
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
      {{ getApiErrorMessage(error, t('catalog_index.load_failed')) }}
    </div>
    <div v-else-if="pending" class="card">
      {{ t('catalog_index.loading') }}
    </div>

    <template v-else-if="data">
      <section v-if="data.data.editorials.length" class="section">
        <div class="section__header section__header--split">
          <div>
            <span class="eyebrow">{{ t('home.editorial_section_eyebrow') }}</span>
            <h2>{{ t('home.editorial_section_title') }}</h2>
          </div>
          <p class="section__copy">
            {{ t('home.editorial_section_description') }}
          </p>
        </div>

        <div class="editorial-grid">
          <article
            v-for="editorial in data.data.editorials"
            :key="`${editorial.category.slug}-${editorial.title}`"
            class="editorial-card"
          >
            <NuxtLink class="editorial-card__media" :to="`/catalog/category/${editorial.category.slug}`">
              <img
                v-if="editorial.category.image"
                :src="editorial.category.image"
                :alt="editorial.title"
                loading="lazy"
              >
              <div v-else class="catalog-media__placeholder" aria-hidden="true"></div>
            </NuxtLink>
            <div class="editorial-card__body">
              <span class="editorial-card__eyebrow">{{ editorial.eyebrow }}</span>
              <h3>{{ editorial.title }}</h3>
              <p>{{ editorial.description }}</p>
              <NuxtLink class="button button--accent" :to="`/catalog/category/${editorial.category.slug}`">
                {{ editorial.cta }}
              </NuxtLink>
            </div>
          </article>
        </div>
      </section>

      <section
        v-for="section in sections"
        :id="section.id"
        :key="section.id"
        class="section"
      >
        <div class="section__header">
          <div>
            <span class="eyebrow">{{ t('header.badge') }}</span>
            <h2>{{ section.title }}</h2>
          </div>
          <button class="button button--ghost" type="button" @click="refresh()">
            {{ t('common.refresh') }}
          </button>
        </div>

        <div class="grid grid--thirds">
          <article
            v-for="product in section.items"
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
              <p v-if="product.brand">{{ product.brand.name }}</p>
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
      </section>
    </template>
  </section>
</template>
