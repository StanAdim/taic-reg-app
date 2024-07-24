// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: ["@nuxtjs/tailwindcss", '@pinia/nuxt', "@element-plus/nuxt"],
  app: {
    pageTransition: { name: 'page', mode: 'out-in' , name: 'fade' },
    layoutTransition: { name: 'layout', mode: 'out-in' ,    name: 'bounce',},
    head: {
      title: 'EMS ICT Commission', // Set the default title for your application
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
    },
    pageTransition: {
      name: 'fade',
      mode: 'out-in' // default
    },
    layoutTransition: {
      name: 'slide',
      mode: 'out-in' // default
       },
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