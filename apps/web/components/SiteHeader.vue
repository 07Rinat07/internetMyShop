<script setup lang="ts">
const auth = useAuth()
const navItems = [
  { to: '/', label: 'Home' },
  { to: '/catalog', label: 'Catalog' },
  { to: '/profile', label: 'Profile' },
  { to: '/orders', label: 'Orders' },
]

const loggingOut = ref(false)

async function handleLogout() {
  loggingOut.value = true

  try {
    await auth.logout()
  } finally {
    loggingOut.value = false
  }
}
</script>

<template>
  <header class="site-header">
    <div class="site-header__inner">
      <NuxtLink class="brand-lockup" to="/">
        <span class="brand-lockup__title">internetMyShop</span>
        <span class="brand-lockup__subtitle">Nuxt storefront over Laravel API v1</span>
      </NuxtLink>

      <nav class="site-nav">
        <NuxtLink
          v-for="item in navItems"
          :key="item.to"
          :to="item.to"
          class="nav-link"
        >
          {{ item.label }}
        </NuxtLink>

        <template v-if="auth.loggedIn.value">
          <span class="pill">
            Signed in
            <strong>{{ auth.user.value?.name || 'API user' }}</strong>
          </span>
          <button
            class="button button--ghost"
            type="button"
            :disabled="loggingOut"
            @click="handleLogout"
          >
            {{ loggingOut ? 'Signing out...' : 'Logout' }}
          </button>
        </template>
        <NuxtLink
          v-else
          class="button button--accent"
          to="/login"
        >
          Login
        </NuxtLink>
      </nav>
    </div>
  </header>
</template>
