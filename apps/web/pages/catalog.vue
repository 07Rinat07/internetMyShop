<script setup lang="ts">
import type { ApiEnvelope, CatalogIndexPayload } from '~/types/api'

const api = useApiClient()
const { t } = useLocale()

const { data, error, pending, refresh } = await useAsyncData('catalog-index', () =>
  api<ApiEnvelope<CatalogIndexPayload>>('/catalog'),
)
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">{{ t('catalog_index.hero_eyebrow') }}</span>
    <h1>{{ t('catalog_index.hero_title') }}</h1>
    <p>
      {{ t('catalog_index.hero_description') }}
    </p>
  </section>

  <section class="section">
    <div v-if="error" class="status status--error">
      {{ getApiErrorMessage(error, t('catalog_index.load_failed')) }}
    </div>

    <div v-else-if="pending" class="card">
      {{ t('catalog_index.loading') }}
    </div>

    <template v-else-if="data">
      <div class="section__header">
        <div>
          <span class="eyebrow">{{ t('catalog_index.categories_eyebrow') }}</span>
          <h2>{{ t('catalog_index.categories_title') }}</h2>
        </div>
        <button class="button button--ghost" type="button" @click="refresh()">
          {{ t('common.refresh') }}
        </button>
      </div>

      <div class="grid grid--halves">
        <article
          v-for="category in data.data.categories"
          :key="category.id"
          class="card stack"
        >
          <div class="catalog-media catalog-media--category">
            <img
              v-if="category.image"
              :src="category.image"
              :alt="category.name"
              class="catalog-media__image"
              loading="lazy"
            >
            <div v-else class="catalog-media__placeholder" aria-hidden="true"></div>
          </div>

          <div class="stack">
            <span class="pill">{{ t('catalog_index.category_pill') }}</span>
            <h3>
              <NuxtLink :to="`/catalog/category/${category.slug}`">
                {{ category.name }}
              </NuxtLink>
            </h3>
            <p>{{ category.content || t('catalog_index.no_category_description') }}</p>
          </div>

          <div class="actions">
            <NuxtLink class="button button--ghost" :to="`/catalog/category/${category.slug}`">
              {{ t('catalog_index.browse_products') }}
            </NuxtLink>
          </div>

          <div v-if="category.children.length" class="stack">
            <span class="eyebrow">{{ t('common.children') }}</span>
            <div class="pill-row">
              <NuxtLink
                v-for="child in category.children"
                :key="child.id"
                class="pill"
                :to="`/catalog/category/${child.slug}`"
              >
                {{ child.name }}
              </NuxtLink>
            </div>
          </div>
        </article>
      </div>

      <div class="section section__header">
        <div>
          <span class="eyebrow">{{ t('catalog_index.brands_eyebrow') }}</span>
          <h2>{{ t('catalog_index.brands_title') }}</h2>
        </div>
      </div>

      <div class="grid grid--thirds">
        <article
          v-for="brand in data.data.brands"
          :key="brand.id"
          class="card card--compact stack"
        >
          <div class="catalog-media catalog-media--brand">
            <img
              v-if="brand.image"
              :src="brand.image"
              :alt="brand.name"
              class="catalog-media__image"
              loading="lazy"
            >
            <div v-else class="catalog-media__placeholder" aria-hidden="true"></div>
          </div>

          <span class="pill">{{ t('catalog_index.brand_pill') }}</span>
          <h3>
            <NuxtLink :to="`/brands/${brand.slug}`">
              {{ brand.name }}
            </NuxtLink>
          </h3>
          <p>{{ brand.content || t('catalog_index.no_brand_description') }}</p>
          <div class="actions">
            <NuxtLink class="button button--ghost" :to="`/brands/${brand.slug}`">
              {{ t('catalog_index.open_brand') }}
            </NuxtLink>
          </div>
        </article>
      </div>
    </template>
  </section>
</template>
