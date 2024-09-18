<script setup>
const global = useGlobalDataStore()
// const siteStore = useSiteDataStore()

// async function retriveSitedata() {
//   const {data, error}  = await siteStore.retriveSiteData()
// }
// retriveSitedata()
const getSitedData = ref({
    conferenceYear: 2024,
    theme: 'Unleashing the Power of Artificial Intelligence and Robotics for socio-economic Transformation',
    venue: 'Julius Nyerere International Convention Centre (JNICC)',
    location:'Dar es salaam'
})
</script>
<template>
    <section id="hero" class="hero sticked-header-offset">
<!--        <particle />-->
        <!-- <div id="repulse-circle-div"></div> -->
        <!-- <div class="container position-relative landing-focus" v-if="siteStore.getSitedData"> -->
        <div class="container position-relative landing-focus" >
            <div class="row gy-5 aos-init aos-animate">
                <div class="col-lg-7 offset-lg-5 dark-bg order-lg-1 d-flex flex-column justify-content-start text-left caption">
                    <!-- <h2 data-aos="fade-up">Delivering Superior Services <span>IT Solutions</span><span class="circle" data-aos="fade-right" data-aos-delay="800">.</span></h2> -->
                    <h2 data-aos="fade-up">{{global.longName}}<span class="mx-2"> {{getSitedData?.conferenceYear}}</span></h2>
                    <h3 data-aos="fade-up" data-aos-delay="500" class="my-2">{{getSitedData?.theme}}</h3>
                    
                    <!-- <p data-aos="fade-up" data-aos-delay="400">You can easily change any design to your own. It is also highly customizable SEO friendly template.</p> -->
                    <p class="event-dates" data-aos="fade-up" data-aos-delay="400">13<sup>tht</sup> - 17<sup>th</sup> October 2024</p>
                    <p class="event-dates" data-aos="fade-up" data-aos-delay="400">Location: {{getSitedData?.location}}</p>
                    <p class="event-dates" data-aos="fade-up" data-aos-delay="400">{{getSitedData?.venue}}</p>
                    <div class="d-flex justify-content-start">
                        <!-- <a href="#contact" class="btn-get-started mr-20" data-aos="fade-up" data-aos-delay="800">Get Quotes</a> -->
                      <a href="https://ems.ictc.go.tz" class="btn-get-started" data-aos="fade-up" data-aos-delay="1000">Register Now</a>
<!--                      <a href="/static/files/documents/ConceptNote.pdf" target="_blank">-->
                      <a href="/static/files/documents/TAIC_2024_Concept_new.pdf" target="_blank">
                          <usables-dowload-btn name="TAIC Extra Details" />
                      </a>
                      <a href="/static/files/documents/call_for_speakers_2024.pdf" target="_blank">
                        <usables-dowload-btn name="Call For Speakers" />
                      </a>
                    </div>
                </div>
            </div>
        </div>
      </section>
<!-- End Hero Section -->
</template>

<style scoped></style>
