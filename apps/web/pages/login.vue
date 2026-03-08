<script setup lang="ts">
import type { LoginPayload, RegisterPayload } from '~/types/api'

definePageMeta({
  middleware: 'guest',
})

const auth = useAuth()
const route = useRoute()

const mode = ref<'login' | 'register'>('login')
const feedback = ref('')
const errorMessage = ref('')

const loginForm = reactive<LoginPayload>({
  email: '',
  password: '',
  device_name: 'nuxt-web',
})

const registerForm = reactive<RegisterPayload>({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  device_name: 'nuxt-web',
})

const currentEmail = computed({
  get: () => (mode.value === 'login' ? loginForm.email : registerForm.email),
  set: (value: string) => {
    if (mode.value === 'login') {
      loginForm.email = value
      return
    }

    registerForm.email = value
  },
})

const currentPassword = computed({
  get: () => (mode.value === 'login' ? loginForm.password : registerForm.password),
  set: (value: string) => {
    if (mode.value === 'login') {
      loginForm.password = value
      return
    }

    registerForm.password = value
  },
})

async function submit() {
  errorMessage.value = ''
  feedback.value = ''

  try {
    if (mode.value === 'login') {
      await auth.login(loginForm)
      feedback.value = 'Signed in through Sanctum.'
    } else {
      await auth.register(registerForm)
      feedback.value = 'Account created and token issued.'
    }

    await navigateTo((route.query.redirect as string) || '/profile')
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, 'Authentication request failed.')
  }
}
</script>

<template>
  <div class="split">
    <section class="hero">
      <span class="hero__eyebrow">Auth Gateway</span>
      <h1>Login and registration now live outside the monolith.</h1>
      <p>
        This screen talks directly to <span class="mono">/api/v1/auth/*</span> and stores the
        issued Sanctum token for account pages like profiles and orders.
      </p>

      <div class="metric-row">
        <div class="metric">
          <span class="muted">Contract</span>
          <strong>Bearer</strong>
        </div>
        <div class="metric">
          <span class="muted">Runtime</span>
          <strong>Nuxt 3</strong>
        </div>
        <div class="metric">
          <span class="muted">Backend</span>
          <strong>Laravel API</strong>
        </div>
      </div>
    </section>

    <section class="card stack">
      <div class="section__header">
        <div>
          <span class="eyebrow">Access</span>
          <h2>{{ mode === 'login' ? 'Sign in' : 'Create account' }}</h2>
        </div>
        <div class="pill-row">
          <button
            class="button"
            :class="mode === 'login' ? 'button--accent' : 'button--ghost'"
            type="button"
            @click="mode = 'login'"
          >
            Login
          </button>
          <button
            class="button"
            :class="mode === 'register' ? 'button--accent' : 'button--ghost'"
            type="button"
            @click="mode = 'register'"
          >
            Register
          </button>
        </div>
      </div>

      <form class="form-grid" @submit.prevent="submit">
        <template v-if="mode === 'register'">
          <div class="field">
            <label for="register-name">Name</label>
            <input
              id="register-name"
              v-model="registerForm.name"
              class="input"
              name="name"
              required
            >
          </div>
        </template>

        <div class="field">
          <label :for="mode === 'login' ? 'login-email' : 'register-email'">Email</label>
          <input
            :id="mode === 'login' ? 'login-email' : 'register-email'"
            v-model="currentEmail"
            class="input"
            name="email"
            type="email"
            autocomplete="email"
            required
          >
        </div>

        <div class="field">
          <label :for="mode === 'login' ? 'login-password' : 'register-password'">Password</label>
          <input
            :id="mode === 'login' ? 'login-password' : 'register-password'"
            v-model="currentPassword"
            class="input"
            name="password"
            type="password"
            autocomplete="current-password"
            required
          >
        </div>

        <template v-if="mode === 'register'">
          <div class="field">
            <label for="register-password-confirmation">Confirm password</label>
            <input
              id="register-password-confirmation"
              v-model="registerForm.password_confirmation"
              class="input"
              name="password_confirmation"
              type="password"
              autocomplete="new-password"
              required
            >
          </div>
        </template>

        <div v-if="errorMessage" class="status status--error">
          {{ errorMessage }}
        </div>
        <div v-if="feedback" class="status status--success">
          {{ feedback }}
        </div>

        <button class="button button--accent" type="submit" :disabled="auth.busy.value">
          {{ auth.busy.value ? 'Submitting...' : mode === 'login' ? 'Login' : 'Register' }}
        </button>
      </form>
    </section>
  </div>
</template>
