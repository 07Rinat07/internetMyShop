<script setup lang="ts">
const auth = useAuth()
const basket = useBasket()
const { locale, localeOptions, setLocale, t } = useLocale()
const navItems = computed(() => ([
  { to: '/', label: t('nav.home') },
  { to: '/catalog', label: t('nav.catalog') },
  { to: '/basket', label: t('nav.basket') },
  { to: '/profile', label: t('nav.profile') },
  { to: '/orders', label: t('nav.orders') },
]))

const loggingOut = ref(false)

async function handleLogout() {
  loggingOut.value = true

  try {
    await auth.logout()
  } finally {
    loggingOut.value = false
  }
}

function selectLocale(nextLocale: string) {
  setLocale(nextLocale)
}
</script>

<template>
  <header class="site-header">
    <div class="site-header__inner">
      <div class="site-header__intro">
        <NuxtLink class="brand-lockup" to="/">
          <span class="brand-lockup__mark">IM</span>
          <span class="brand-lockup__copy">
            <span class="brand-lockup__title">internetMyShop</span>
            <span class="brand-lockup__subtitle">{{ t('header.badge') }}</span>
          </span>
        </NuxtLink>

        <div class="site-header__message">
          <span class="site-pill">{{ t('header.badge') }}</span>
          <p>{{ t('header.subtitle') }}</p>
        </div>
      </div>

      <nav class="site-nav">
        <div class="locale-switch" :aria-label="t('common.language')">
          <button
            v-for="option in localeOptions"
            :key="option.code"
            class="locale-switch__button"
            :class="{ 'locale-switch__button--active': option.code === locale }"
            type="button"
            @click="selectLocale(option.code)"
          >
            {{ option.label }}
          </button>
        </div>

        <NuxtLink
          v-for="item in navItems"
          :key="item.to"
          :to="item.to"
          class="nav-link"
        >
          <template v-if="item.to === '/basket'">
            {{ item.label }} <span v-if="basket.positions.value">({{ basket.positions.value }})</span>
          </template>
          <template v-else>
            {{ item.label }}
          </template>
        </NuxtLink>

        <template v-if="auth.loggedIn.value">
          <span class="pill">
            {{ t('header.signed_in') }}
            <strong>{{ auth.user.value?.name || t('header.api_user') }}</strong>
          </span>
          <button
            class="button button--ghost"
            type="button"
            :disabled="loggingOut"
            @click="handleLogout"
          >
            {{ loggingOut ? t('header.logging_out') : t('header.logout') }}
          </button>
        </template>
        <NuxtLink
          v-else
          class="button button--accent"
          to="/login"
        >
          {{ t('header.login') }}
        </NuxtLink>
      </nav>
    </div>
  </header>
</template>
