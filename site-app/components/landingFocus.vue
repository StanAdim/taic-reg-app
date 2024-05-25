<script setup>
const global = useGlobalDataStore()
const siteStore = useSiteDataStore()
</script>
<template>
    <section id="hero" class="hero sticked-header-offset">
<!--        <particle />-->
        <!-- <div id="repulse-circle-div"></div> -->
         <div class="container position-relative landing-focus" v-if="siteStore.getSitedData">
            <div class="row gy-5 aos-init aos-animate">
                <div class="col-lg-7 offset-lg-5 dark-bg order-lg-1 d-flex flex-column justify-content-start text-left caption">
                    <!-- <h2 data-aos="fade-up">Delivering Superior Services <span>IT Solutions</span><span class="circle" data-aos="fade-right" data-aos-delay="800">.</span></h2> -->
                    <h2 data-aos="fade-up">{{global.getAppLongName}}<span class="mx-2"> {{siteStore.getSitedData?.conferenceYear}}</span></h2>
                    <h3 data-aos="fade-up" data-aos-delay="500" class="my-2">{{siteStore.getSitedData?.theme}}</h3>
                    
                    <!-- <p data-aos="fade-up" data-aos-delay="400">You can easily change any design to your own. It is also highly customizable SEO friendly template.</p> -->
                    <p  class="event-dates" data-aos="fade-up" data-aos-delay="400">Start
                        <span class="event-duration">
                            {{siteStore.getSitedData?.startDate}}
                        </span>
                    </p>
                    <p  class="event-dates" data-aos="fade-up" data-aos-delay="400">Closing
                        <span class="event-duration">
                            {{siteStore.getSitedData?.endDate}}                        
                        </span>
                    </p>
                    <p class="event-dates" data-aos="fade-up" data-aos-delay="400">Location: {{siteStore.getSitedData?.venue}}</p>
                    <p class="event-dates" data-aos="fade-up" data-aos-delay="400">{{siteStore.getSitedData?.venue}}</p>
                    <div class="d-flex justify-content-start">
                        <!-- <a href="#contact" class="btn-get-started mr-20" data-aos="fade-up" data-aos-delay="800">Get Quotes</a> -->
                        <!-- <a href="#registerNow" class="btn-get-started" data-aos="fade-up" data-aos-delay="1000">Register Now</a> -->
                    </div>
                </div>
            </div>
        </div>
      </section>
<!-- End Hero Section -->
</template>

<style scoped></style>
