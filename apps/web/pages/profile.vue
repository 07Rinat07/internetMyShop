<script setup lang="ts">
import type { ApiEnvelope, Profile, ProfilePayload } from '~/types/api'

definePageMeta({
  middleware: 'auth',
})

const api = useApiClient()
const auth = useAuth()
const { t } = useLocale()

await auth.ensureUser()

const { data, error, pending, refresh } = await useAsyncData('profiles', () =>
  api<ApiEnvelope<Profile[]>>('/profiles'),
)

const form = reactive<ProfilePayload>({
  title: '',
  name: auth.user.value?.name || '',
  email: auth.user.value?.email || '',
  phone: '',
  address: '',
  comment: '',
})

const feedback = ref('')
const errorMessage = ref('')
const submitting = ref(false)

async function submitProfile() {
  submitting.value = true
  feedback.value = ''
  errorMessage.value = ''

  try {
    await api<ApiEnvelope<Profile>>('/profiles', {
      method: 'POST',
      body: form,
    })

    feedback.value = t('profile_page.saved')
    form.title = ''
    form.phone = ''
    form.address = ''
    form.comment = ''
    await refresh()
  } catch (requestError) {
    errorMessage.value = getApiErrorMessage(requestError, t('profile_page.save_failed'))
  } finally {
    submitting.value = false
  }
}

async function removeProfile(profileId: number) {
  errorMessage.value = ''
  feedback.value = ''

  try {
    await api(`/profiles/${profileId}`, { method: 'DELETE' })
    feedback.value = t('profile_page.deleted')
    await refresh()
  } catch (requestError) {
    errorMessage.value = getApiErrorMessage(requestError, t('profile_page.delete_failed'))
  }
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">{{ t('profile_page.hero_eyebrow') }}</span>
    <h1>{{ t('profile_page.hero_title') }}</h1>
    <p>
      {{ t('profile_page.hero_description') }}
    </p>

    <div class="metric-row">
      <div class="metric">
        <span class="muted">{{ t('profile_page.signed_in_as') }}</span>
        <strong>{{ auth.user.value?.name || t('common.unknown_user') }}</strong>
      </div>
      <div class="metric">
        <span class="muted">{{ t('profile_page.email') }}</span>
        <strong class="mono">{{ auth.user.value?.email || t('common.no_email') }}</strong>
      </div>
    </div>
  </section>

  <section class="section split">
    <article class="card stack">
      <div>
        <span class="eyebrow">{{ t('profile_page.new_profile') }}</span>
        <h2>{{ t('profile_page.create_identity') }}</h2>
      </div>

      <form class="form-grid" @submit.prevent="submitProfile">
        <div class="form-grid form-grid--two">
          <div class="field">
            <label for="profile-title">{{ t('profile_page.title') }}</label>
            <input id="profile-title" v-model="form.title" class="input" required>
          </div>
          <div class="field">
            <label for="profile-name">{{ t('profile_page.name') }}</label>
            <input id="profile-name" v-model="form.name" class="input" required>
          </div>
        </div>

        <div class="form-grid form-grid--two">
          <div class="field">
            <label for="profile-email">{{ t('profile_page.email') }}</label>
            <input id="profile-email" v-model="form.email" class="input" type="email" required>
          </div>
          <div class="field">
            <label for="profile-phone">{{ t('profile_page.phone') }}</label>
            <input id="profile-phone" v-model="form.phone" class="input" required>
          </div>
        </div>

        <div class="field">
          <label for="profile-address">{{ t('profile_page.address') }}</label>
          <textarea id="profile-address" v-model="form.address" class="textarea" required></textarea>
        </div>

        <div class="field">
          <label for="profile-comment">{{ t('profile_page.comment') }}</label>
          <textarea id="profile-comment" v-model="form.comment" class="textarea"></textarea>
        </div>

        <div v-if="errorMessage" class="status status--error">
          {{ errorMessage }}
        </div>
        <div v-if="feedback" class="status status--success">
          {{ feedback }}
        </div>

        <button class="button button--accent" type="submit" :disabled="submitting">
          {{ submitting ? t('common.saving') : t('profile_page.save_button') }}
        </button>
      </form>
    </article>

    <article class="card stack">
      <div class="section__header">
        <div>
          <span class="eyebrow">{{ t('profile_page.saved_profiles') }}</span>
          <h2>{{ t('profile_page.current_records') }}</h2>
        </div>
        <button class="button button--ghost" type="button" @click="refresh()">
          {{ t('common.refresh') }}
        </button>
      </div>

      <div v-if="error" class="status status--error">
        {{ getApiErrorMessage(error, t('profile_page.load_failed')) }}
      </div>
      <div v-else-if="pending" class="card card--compact">
        {{ t('profile_page.loading') }}
      </div>
      <div v-else-if="!data?.data.length" class="empty-state">
        <p>{{ t('profile_page.empty') }}</p>
      </div>
      <div v-else class="list">
        <article
          v-for="profile in data.data"
          :key="profile.id"
          class="list-item"
        >
          <div class="list-item__header">
            <div>
              <strong>{{ profile.title }}</strong>
              <p>{{ profile.name }}</p>
            </div>
            <button
              class="button button--danger"
              type="button"
              @click="removeProfile(profile.id)"
            >
              {{ t('common.delete') }}
            </button>
          </div>

          <div class="stack">
            <span class="muted mono">{{ profile.email }}</span>
            <span>{{ profile.phone }}</span>
            <span>{{ profile.address }}</span>
            <span v-if="profile.comment" class="muted">{{ profile.comment }}</span>
          </div>
        </article>
      </div>
    </article>
  </section>
</template>
