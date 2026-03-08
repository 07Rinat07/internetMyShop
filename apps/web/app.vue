<script setup lang="ts">
const auth = useAuth()

if (auth.token.value && !auth.user.value) {
  await callOnce('auth-bootstrap', () => auth.ensureUser())
}
</script>

<template>
  <NuxtLayout>
    <NuxtPage />
  </NuxtLayout>
</template>
