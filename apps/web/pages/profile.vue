<script setup lang="ts">
import type { ApiEnvelope, Profile, ProfilePayload } from '~/types/api'

definePageMeta({
  middleware: 'auth',
})

const api = useApiClient()
const auth = useAuth()

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

    feedback.value = 'Profile saved through the API.'
    form.title = ''
    form.phone = ''
    form.address = ''
    form.comment = ''
    await refresh()
  } catch (requestError) {
    errorMessage.value = getApiErrorMessage(requestError, 'Failed to save profile.')
  } finally {
    submitting.value = false
  }
}

async function removeProfile(profileId: number) {
  errorMessage.value = ''
  feedback.value = ''

  try {
    await api(`/profiles/${profileId}`, { method: 'DELETE' })
    feedback.value = 'Profile deleted.'
    await refresh()
  } catch (requestError) {
    errorMessage.value = getApiErrorMessage(requestError, 'Failed to delete profile.')
  }
}
</script>

<template>
  <section class="hero">
    <span class="hero__eyebrow">Account</span>
    <h1>Shipping profiles now run on the API contract.</h1>
    <p>
      The frontend restores the authenticated user from Sanctum and manages profile CRUD against
      the protected <span class="mono">/profiles</span> endpoints.
    </p>

    <div class="metric-row">
      <div class="metric">
        <span class="muted">Signed in as</span>
        <strong>{{ auth.user.value?.name || 'Unknown user' }}</strong>
      </div>
      <div class="metric">
        <span class="muted">Email</span>
        <strong class="mono">{{ auth.user.value?.email || 'n/a' }}</strong>
      </div>
    </div>
  </section>

  <section class="section split">
    <article class="card stack">
      <div>
        <span class="eyebrow">New profile</span>
        <h2>Create delivery identity</h2>
      </div>

      <form class="form-grid" @submit.prevent="submitProfile">
        <div class="form-grid form-grid--two">
          <div class="field">
            <label for="profile-title">Title</label>
            <input id="profile-title" v-model="form.title" class="input" required>
          </div>
          <div class="field">
            <label for="profile-name">Name</label>
            <input id="profile-name" v-model="form.name" class="input" required>
          </div>
        </div>

        <div class="form-grid form-grid--two">
          <div class="field">
            <label for="profile-email">Email</label>
            <input id="profile-email" v-model="form.email" class="input" type="email" required>
          </div>
          <div class="field">
            <label for="profile-phone">Phone</label>
            <input id="profile-phone" v-model="form.phone" class="input" required>
          </div>
        </div>

        <div class="field">
          <label for="profile-address">Address</label>
          <textarea id="profile-address" v-model="form.address" class="textarea" required></textarea>
        </div>

        <div class="field">
          <label for="profile-comment">Comment</label>
          <textarea id="profile-comment" v-model="form.comment" class="textarea"></textarea>
        </div>

        <div v-if="errorMessage" class="status status--error">
          {{ errorMessage }}
        </div>
        <div v-if="feedback" class="status status--success">
          {{ feedback }}
        </div>

        <button class="button button--accent" type="submit" :disabled="submitting">
          {{ submitting ? 'Saving...' : 'Save profile' }}
        </button>
      </form>
    </article>

    <article class="card stack">
      <div class="section__header">
        <div>
          <span class="eyebrow">Saved profiles</span>
          <h2>Current API records</h2>
        </div>
        <button class="button button--ghost" type="button" @click="refresh()">
          Refresh
        </button>
      </div>

      <div v-if="error" class="status status--error">
        {{ getApiErrorMessage(error, 'Failed to load profiles.') }}
      </div>
      <div v-else-if="pending" class="card card--compact">
        Loading profiles...
      </div>
      <div v-else-if="!data?.data.length" class="empty-state">
        <p>No profiles yet. Create the first delivery profile on the left.</p>
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
              Delete
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
