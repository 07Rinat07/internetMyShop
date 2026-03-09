<script setup lang="ts">
const { t } = useLocale()
</script>

<template>
  <footer class="site-footer">
    <div class="site-footer__inner">
      <div class="site-footer__surface">
        <div class="site-footer__brand">
          <NuxtLink class="brand-lockup brand-lockup--footer" to="/">
            <span class="brand-lockup__mark">IM</span>
            <span class="brand-lockup__copy">
              <span class="brand-lockup__title">{{ t('footer.title') }}</span>
              <span class="brand-lockup__subtitle">{{ t('header.badge') }}</span>
            </span>
          </NuxtLink>

          <div class="site-footer__copy">
            <span class="site-pill">{{ t('header.badge') }}</span>
            <p>{{ t('footer.description') }}</p>
          </div>
        </div>

        <small class="site-footer__note">{{ t('footer.note') }}</small>
      </div>
    </div>
  </footer>
</template>
