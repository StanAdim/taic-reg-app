<script setup>
const hasHonarableGuest = ref(true)
const speakerList = ref([
  {fullName: 'To be known', designation: 
  'Designation', imgPath: '/team/placeholder.jpg'
   ,linkedIn: '', xLink: ''},
  {fullName: 'To be known', designation: 
  'Designation', imgPath: '/team/placeholder.jpg'
   ,linkedIn: '', xLink: ''},
  {fullName: 'To be known', designation: 
  'Designation', imgPath: '/team/placeholder.jpg'
   ,linkedIn: '', xLink: ''},
  {fullName: 'To be known', designation: 
  'Designation', imgPath: '/team/placeholder.jpg'
   ,linkedIn: '', xLink: ''},
])
const siteDataStore = useSiteDataStore()
const config = useRuntimeConfig()
const apiBaseUlr = config.public.apiBaseUlr
const imageFullPath = (imgPath) => {
  if (!imgPath){
    return `/team/placeholder.jpg`
  }else {
    return `${apiBaseUlr}/${imgPath}`
  }
}
const init = async  ()=> {
  await siteDataStore.retrieveConferenceSpeakers()
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
<!--  Our Team Section  -->
<section id="team" class="team sections-bg">
    <div class="container aos-init aos-animate" data-aos="fade-up">

        <div class="section-header">
            <h2>CONFERENCE SPEAKER</h2>
            <p class="text-center">Speakers and Presenter and Facilitators</p>
        </div>
<!--        <div class="row gy-1 justify-content-center justify-center">-->
<!--          <div class="col-md-6 aos-init aos-animate" >-->
<!--            <p class="text-center key-speaker">GUEST OF HONOUR</p>-->
<!--            <UsablesSpinLoader v-if="!hasHonarableGuest" />-->
<!--            <div class="" v-if="hasHonarableGuest">-->
<!--                <img src="/team/placeholder.jpg" class="img-fluid" alt="">-->
<!--                <h4>Sani Awesome</h4>-->
<!--                <span>Social Media</span>-->
<!--                <div class="social">-->
<!--                    <a href=""><i class="bi bi-twitter"></i></a>-->
<!--                    <a href=""><i class="bi bi-linkedin"></i></a>-->
<!--                </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
        <div class="row gy-4 justify-content-center">
          <p class="text-center key-speaker">CONFERENCE PRESENTERS</p>

          <template  v-for="item in siteDataStore.getEventSpeakers" :key="item">
            <div class="col-xl-3 col-md-6 d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="member">

                    <img :src="imageFullPath(item.imgPath)" class="img-fluid" :alt="item?.name">
                    <h4>{{item?.name}}</h4>
                    <span>{{item.designation}}</span>
                    <div class="social">
                        <a :href="`https://x.com/ict_commission`" target="_blank"><i class="bi bi-twitter"></i></a>
                        <a :href="`https://www.linkedin.com/company/ict-commission-tanzania/`" target="_blank"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
          </template>
            <!-- End Team Member -->
        </div>

    </div>
</section>
<!-- End Our Team Section -->
</template>

<style scoped>
</style>
