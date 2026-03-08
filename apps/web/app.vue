<script setup lang="ts">
const auth = useAuth()
const basket = useBasket()

await callOnce('auth-bootstrap', () => auth.ensureUser())

if (import.meta.client && !basket.initialized.value) {
  basket.load().catch(() => null)
}
</script>

<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>
