<script setup lang="ts">
const exhibitor = ref([
  //   aspect ratio 4500 x 4072
  {name: 'liquid', pathName: 'liquid-logo.png'},
  {name: 'liquid', pathName: 'flashnet-logo.png'},
  {name: 'liquid', pathName: 'sag-logo.png'},
])
const sponsors = ref([
  {name: '', pathName: 'ucsaf-logos.png' , category: "SILVER"},
  {name: '', pathName: 'huawei-logos.png' , category: "PLATINUM"},
  {name: '', pathName: 'fsd-logos.png' , category: "SILVER"}
])
// const getImagePath = (imageName: string) => `/logo/sponsor/${imageName}`;
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
  await siteDataStore.retrieveSiteSponsors()
}
onNuxtReady(()=> {
  init()
})
</script>

<template>
    <div class="PARTNERS">
<!--      Sponsors-->
      <section id="sponsors" class="partner-logos" v-if="sponsors.length != 0">
        <UsablesLandingSectionHead title="OUR SPONSORS" sub-title="" />
        <div class="logo-container">
          <div v-for="item in siteDataStore.getEventSponsors" :key="item?.imgPath" class="logo-item">
            <img :src="imageFullPath(item.imgPath)" :alt="item?.name">
            <p>{{item?.sub_category}}</p>
          </div>
        </div>
      </section>
<!--      PARTNERS-->
      <section id="partners" class="partner-logos" v-if="exhibitor.length != 0">
        <UsablesLandingSectionHead title="PARTNERS" sub-title="" />
        <div class="logo-container">
          <div v-for="item in siteDataStore.getEventPartners" :key="item.imgPath" class="logo-item">
            <img :src="imageFullPath(item.imgPath)" :alt="item.name">
          </div>
        </div>
      </section>
      <!--      EXHIBITORS-->
      <section id="exhibitors" class="partner-logos" v-if="exhibitor.length != 0">
        <UsablesLandingSectionHead title="EXHIBITORS" sub-title="" />
        <div class="logo-container">
          <div v-for="item in siteDataStore.getEventExhibitors" :key="item.imgPath" class="logo-item">
            <img :src="imageFullPath(item.imgPath)" :alt="item.name">
          </div>
        </div>
      </section>
    </div>
</template>

<style scoped>
/* General Styles */
.section-partner {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
}

/* Partner Logos Section */
.partner-logos {
  padding: 20px;
  //background-color: #f5f5f5;
}

.logo-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 20px;
  padding: 10px 2px;
}
.logo-container p{
  margin: 0;
  color: #f68e16;
}

.logo-item {
  flex: 1 1 200px;
  max-width: 200px;
  padding: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  transition: transform 0.3s ease;
  text-align: center;
}

.logo-item img {
  max-width: 100%;
  height: auto;
  display: block;
  margin: 0 auto;
}

.logo-item:hover {
  transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
  .logo-item {
    flex: 1 1 100px;
    max-width: 100px;
  }
}

@media (max-width: 480px) {
  .logo-item {
    flex: 1 1 80px;
    max-width: 80px;
  }
}

</style>