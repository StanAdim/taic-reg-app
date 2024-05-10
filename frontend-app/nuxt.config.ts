// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: [
      "@nuxtjs/tailwindcss",
      '@pinia/nuxt',
  ],
  app: {
    head: {
      title: 'TAIC - Registration', // Set the default title for your application
      meta: [
        { charset: 'utf-8' },
        { 'http-equiv': 'pragma', content: 'no-cache' },
        { 'http-equiv': 'cache-control', content: 'no-cache' },
        { 'http-equiv': 'expires', content: '0' },
        { content: 'telephone=no', name: 'format-detection' }
      ],
      link: [
        // { rel: 'icon', type: 'image/x-icon', href: '/logo/ico.png' }
      ],
      script: [

      ],
      style: [

      ]
    }
  },
  runtimeConfig:{
    public:{
      appName:  'TAIC - Registration App',
      apiBaseUlr: process.env.API_URL ,
      baseUrl: process.env.BASE_URL,
    }
  },
  css:[
    '~/assets/stylesheets/custom-styles.css',
    '~/assets/fontawesome/css/fontawesome.min.css',
    '~/assets/fontawesome/css/solid.min.css','~/assets/fontawesome/css/brands.min.css',
  ]
})