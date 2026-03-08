<script setup lang="ts">
const config = useRuntimeConfig()
const auth = useAuth()
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">Stage 4 / Separate Frontend</span>
    <h1>Nuxt storefront wired to the Laravel API contract.</h1>
    <p>
      This frontend consumes the new <span class="mono">{{ config.public.apiBase }}</span>
      endpoints, keeps basket requests credentialed, and uses Sanctum bearer tokens for
      private account flows.
    </p>

    <div class="hero__actions">
      <NuxtLink class="button button--accent" to="/catalog">
        Open catalog
      </NuxtLink>
      <NuxtLink
        v-if="auth.loggedIn.value"
        class="button button--ghost"
        to="/profile"
      >
        Go to profile
      </NuxtLink>
      <NuxtLink
        v-else
        class="button button--ghost"
        to="/login"
      >
        Login or register
      </NuxtLink>
    </div>
  </section>

  <section class="section grid grid--thirds">
    <article class="card card--accent stack">
      <span class="eyebrow">Public API</span>
      <h2>Catalog and basket stay accessible before sign-in.</h2>
      <p>
        The frontend is ready to browse categories and brands now. Basket integration can be
        layered on top of the same client because requests already include credentials.
      </p>
    </article>

    <article class="card stack">
      <span class="eyebrow">Private API</span>
      <h2>Profile and order history are token-protected.</h2>
      <p>
        Auth uses the new Sanctum endpoints. The client persists the bearer token and restores
        the signed-in user on refresh.
      </p>
    </article>

    <article class="card stack">
      <span class="eyebrow">Next step</span>
      <h2>Replace Blade screens module by module.</h2>
      <p>
        This app is intentionally small but real: it can now become the main shell for account,
        catalog, checkout and later admin surfaces.
      </p>
    </article>
  </section>
</template>
