import js from '@eslint/js'
import globals from 'globals'
import tseslint from 'typescript-eslint'

const nuxtGlobals = {
  $fetch: 'readonly',
  callOnce: 'readonly',
  computed: 'readonly',
  defineEventHandler: 'readonly',
  defineNuxtConfig: 'readonly',
  defineNuxtRouteMiddleware: 'readonly',
  getApiErrorMessage: 'readonly',
  navigateTo: 'readonly',
  onMounted: 'readonly',
  reactive: 'readonly',
  ref: 'readonly',
  useApiClient: 'readonly',
  useAsyncData: 'readonly',
  useAuth: 'readonly',
  useBasket: 'readonly',
  useCookie: 'readonly',
  useRequestHeaders: 'readonly',
  useRoute: 'readonly',
  useRuntimeConfig: 'readonly',
  useState: 'readonly',
}

export default tseslint.config(
  {
    ignores: [
      '.nuxt/**',
      '.output/**',
      'node_modules/**',
      'playwright-report/**',
      'test-results/**',
    ],
  },
  js.configs.recommended,
  ...tseslint.configs.recommended,
  {
    files: ['**/*.ts'],
    languageOptions: {
      ecmaVersion: 'latest',
      sourceType: 'module',
      globals: {
        ...globals.browser,
        ...globals.node,
        ...nuxtGlobals,
      },
    },
    rules: {
      '@typescript-eslint/consistent-type-imports': ['error', { prefer: 'type-imports' }],
    },
  },
  {
    files: ['**/*.mjs'],
    languageOptions: {
      ecmaVersion: 'latest',
      sourceType: 'module',
      globals: {
        ...globals.node,
      },
    },
  },
)
