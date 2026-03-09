<script setup lang="ts">
import type { LoginPayload, RegisterPayload } from '~/types/api'

definePageMeta({
  middleware: 'guest',
})

const auth = useAuth()
const route = useRoute()
const { t } = useLocale()

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
      feedback.value = t('auth.signed_in_feedback')
    } else {
      await auth.register(registerForm)
      feedback.value = t('auth.registered_feedback')
    }

    await navigateTo((route.query.redirect as string) || '/profile')
  } catch (error) {
    errorMessage.value = getApiErrorMessage(error, t('auth.request_failed'))
  }
}
</script>

<template>
  <div class="split">
    <section class="hero">
      <span class="hero__eyebrow">{{ t('auth.hero_eyebrow') }}</span>
      <h1>{{ t('auth.hero_title') }}</h1>
      <p>
        {{ t('auth.hero_description') }}
      </p>

      <div class="metric-row">
        <div class="metric">
          <span class="muted">{{ t('auth.contract') }}</span>
          <strong>{{ t('auth.metric_access_value') }}</strong>
        </div>
        <div class="metric">
          <span class="muted">{{ t('auth.runtime') }}</span>
          <strong>{{ t('auth.metric_profiles_value') }}</strong>
        </div>
        <div class="metric">
          <span class="muted">{{ t('auth.backend') }}</span>
          <strong>{{ t('auth.metric_orders_value') }}</strong>
        </div>
      </div>
    </section>

    <section class="card stack">
      <div class="section__header">
        <div>
          <span class="eyebrow">{{ t('auth.access') }}</span>
          <h2>{{ mode === 'login' ? t('auth.sign_in') : t('auth.create_account') }}</h2>
        </div>
        <div class="pill-row">
          <button
            class="button"
            :class="mode === 'login' ? 'button--accent' : 'button--ghost'"
            type="button"
            data-testid="auth-mode-login"
            @click="mode = 'login'"
          >
            {{ t('auth.login') }}
          </button>
          <button
            class="button"
            :class="mode === 'register' ? 'button--accent' : 'button--ghost'"
            type="button"
            data-testid="auth-mode-register"
            @click="mode = 'register'"
          >
            {{ t('auth.register') }}
          </button>
        </div>
      </div>

      <form class="form-grid" @submit.prevent="submit">
        <template v-if="mode === 'register'">
          <div class="field">
            <label for="register-name">{{ t('auth.name') }}</label>
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
          <label :for="mode === 'login' ? 'login-email' : 'register-email'">{{ t('auth.email') }}</label>
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
          <label :for="mode === 'login' ? 'login-password' : 'register-password'">{{ t('auth.password') }}</label>
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
            <label for="register-password-confirmation">{{ t('auth.confirm_password') }}</label>
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

        <button class="button button--accent" data-testid="auth-submit" type="submit" :disabled="auth.busy.value">
          {{ auth.busy.value ? t('auth.submitting') : mode === 'login' ? t('auth.login') : t('auth.register') }}
        </button>
      </form>
    </section>
  </div>
</template>
