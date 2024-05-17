<script setup>
const hasHonarableGuest = ref(false)
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
</script>

<template>
<!--  Our Team Section  -->
<section id="team" class="team sections-bg">
    <div class="container aos-init aos-animate" data-aos="fade-up">

        <div class="section-header">
            <h2>CONFERENCE SPEAKER</h2>
            <p class="text-center">Speakers and Presenter and Fanicilitors</p>
        </div>
        <div class="row gy-1 justify-content-center">
          <div class="col-md-6 aos-init aos-animate" >
            <p class="text-center key-speaker">GUEST OF HONOUR</p>
            <UsablesSpinLoader v-if="!hasHonarableGuest" />
            <div class="member" v-if="hasHonarableGuest">
                <img src="/team/placeholder.jpg" class="img-fluid" alt="">
                <h4>Sani Awesome</h4>
                <span>Social Media</span>
                <div class="social">
                    <a href=""><i class="bi bi-twitter"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
          </div>
        </div>
        <div class="row gy-4 justify-content-center">
          <p class="text-center key-speaker">INVITED GUEST</p>

          <template  v-for="item in siteDataStore.getSitedData?.speakers" :key="item">
            <div class="col-xl-3 col-md-6 d-flex aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="member">

                    <img :src="item.imgPath" class="img-fluid" :alt="item?.name">
                    <h4>{{item?.name}}</h4>
                    <span>{{item.designation}}</span>
                    <div class="social">
                        <a :href="item.twitterLink"><i class="bi bi-twitter"></i></a>
                        <a :href="item.linkedinLink"><i class="bi bi-linkedin"></i></a>
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
