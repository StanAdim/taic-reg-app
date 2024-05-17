<script lang="ts" setup></script>

<template>
  <div>
    <TheHeader />
    <!-- Layout: default -->
    <main id="main">
      <slot />
    </main>
    <TheFooter />
  </div>
</template>

<style>
    @import url("~/assets/vendor/aos/aos.css" );
    @import url("~/assets/stylesheets/font-awesome.min.css" );
    @import url("~/assets/vendor/swiper/swiper-bundle.min.css" );
    @import url("~/assets/vendor/glightbox/css/glightbox.min.css" );
    @import url("~/assets/vendor/bootstrap/css/bootstrap.min.css" );
    @import url("~/assets/vendor/bootstrap-icons/bootstrap-icons.css" );
    /* editable css */
    @import url("~/assets/stylesheets/styles.css" );
</style>
