// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: [
    '@pinia/nuxt',
    '@nuxtjs/tailwindcss'
  ],
  app: {
    head: {
      title: 'TAIC - 2024', // Set the default title for your application
      meta: [
        { charset: 'utf-8' },
        { 'http-equiv': 'pragma', content: 'no-cache' },
        { 'http-equiv': 'cache-control', content: 'no-cache' },
        { 'http-equiv': 'expires', content: '0' },
        { content: 'telephone=no', name: 'format-detection' }
      ],
      link: [
        { rel: 'icon', type: 'image/x-icon', href: '/logo/ico.png' }
      ],
      script: [
        { hid:"jquery",  src: "/javascripts/jquery.min.js" , type:'text/javascript'},
        { hid:"plugins",  src: "/javascripts/plugins.js" , type:'text/javascript'},
        { hid:"purecounter",  src: "/javascripts/purecounter_vanilla.js" , type:'text/javascript'},
        { hid:"validator",  src: "/javascripts/validator.min.js" , type:'text/javascript'},
        { hid:"contact_form",  src: "/javascripts/contactform.js" , type:'text/javascript'},
        { hid:"particles",  src: "/javascripts/particles.min.js" , type:'text/javascript'},
        { hid:"script_mains",  src: "/javascripts/script.js" , type:'text/javascript'},

        { hid:"mainjs",  src: "/javascripts/main.js" , type:'text/javascript'},
        { hid:"gliht box",  src: "/js/glightbox.min.js" , type:'text/javascript'},
        { hid:"boostsrap",  src: "/js/bootstrap.bundle.min.js" , type:'text/javascript'},
        { hid:"aos",  src: "/js/aos.js" , type:'text/javascript'},
        { hid:"swiper",  src: "/js/swiper-bundle.min.js" , type:'text/javascript'},
      ],
      style: []
    }
  },
  runtimeConfig:{
    public:{
      appName:  'TAIC',
      apiBaseUlr: process.env.API_URL ,
      baseUrl: process.env.BASE_URL,
    }
  },
  css:[
    '~/assets/stylesheets/custom-styles.css',
    '~/assets/fontawesome/css/fontawesome.min.css',
    '~/assets/fontawesome/css/solid.min.css',
    '~/assets/fontawesome/css/brands.min.css',
  ]
})
