export default defineNuxtConfig({
  devtools: { enabled: true },
  css: ['~/assets/css/main.css'],
  app: {
    head: {
      title: 'internetMyShop Web',
      meta: [
        { name: 'viewport', content: 'width=device-width, initial-scale=1' },
        {
          name: 'description',
          content: 'Separate Nuxt frontend for the internetMyShop Laravel API.',
        },
      ],
    },
  },
  runtimeConfig: {
    backendApiBase: process.env.NUXT_BACKEND_API_BASE
      || process.env.NUXT_API_BASE_INTERNAL
      || 'http://localhost:8000/api/v1',
    public: {
      apiBase: process.env.NUXT_PUBLIC_BFF_BASE || '/bff',
    },
  },
  typescript: {
    strict: true,
    typeCheck: true,
  },
})
