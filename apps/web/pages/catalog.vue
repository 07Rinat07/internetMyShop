<script setup lang="ts">
import type { ApiEnvelope, CatalogIndexPayload } from '~/types/api'

const api = useApiClient()

const { data, error, pending, refresh } = await useAsyncData('catalog-index', () =>
  api<ApiEnvelope<CatalogIndexPayload>>('/catalog'),
)
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">Catalog</span>
    <h1>Public catalog endpoints are ready for the separate frontend.</h1>
    <p>
      This page reads the new API index and shows the current top-level categories and popular
      brands without touching the legacy Blade views.
    </p>
  </section>

  <section class="section">
    <div v-if="error" class="status status--error">
      {{ getApiErrorMessage(error, 'Failed to load catalog index.') }}
    </div>

    <div v-else-if="pending" class="card">
      Loading catalog data...
    </div>

    <template v-else-if="data">
      <div class="section__header">
        <div>
          <span class="eyebrow">Categories</span>
          <h2>Entry points for navigation</h2>
        </div>
        <button class="button button--ghost" type="button" @click="refresh()">
          Refresh
        </button>
      </div>

      <div class="grid grid--halves">
        <article
          v-for="category in data.data.categories"
          :key="category.id"
          class="card stack"
        >
          <div class="stack">
            <span class="pill">Category</span>
            <h3>
              <NuxtLink :to="`/catalog/category/${category.slug}`">
                {{ category.name }}
              </NuxtLink>
            </h3>
            <p>{{ category.content || 'No category description yet.' }}</p>
          </div>

          <div class="actions">
            <NuxtLink class="button button--ghost" :to="`/catalog/category/${category.slug}`">
              Browse products
            </NuxtLink>
          </div>

          <div v-if="category.children.length" class="stack">
            <span class="eyebrow">Children</span>
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
          <span class="eyebrow">Brands</span>
          <h2>Popular brands from the API index</h2>
        </div>
      </div>

      <div class="grid grid--thirds">
        <article
          v-for="brand in data.data.brands"
          :key="brand.id"
          class="card card--compact stack"
        >
          <span class="pill">Brand</span>
          <h3>{{ brand.name }}</h3>
          <p>{{ brand.content || 'No brand description yet.' }}</p>
          <p class="muted mono">slug: {{ brand.slug }}</p>
        </article>
      </div>
    </template>
  </section>
</template>
