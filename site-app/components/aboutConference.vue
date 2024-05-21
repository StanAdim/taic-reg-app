<script setup>
const siteStore = useSiteDataStore()
</script>
<template>
<section>
    <div class="container" id="featured">
        <div class="section-header" data-aos="fade-up" data-aos-delay="100">
            <h2>ABOUT CONFERENCE</h2>
        </div>
        <p>{{siteStore.getSitedData?.aboutConference }}</p>
    </div>
</section>
</template>