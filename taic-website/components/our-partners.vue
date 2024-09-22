<script setup lang="ts">
const exhibitor = ref([
  // {name: 'liquid', pathName: 'liquid-logo.png'},
])
const sponsors = ref([
  // {name: '', pathName: 'liquid-logo.png'}
])
const getImagePath = (imageName: string) => `/logo/sponsor/${imageName}`;
</script>

<template>
    <div class="section-partner">
<!--      Sponsors-->
      <section id="sponsors" class="partner-logos" v-if="sponsors.length != 0">
        <UsablesLandingSectionHead title="OUR SPONSORS" sub-title="" />
        <div class="logo-container">
          <div v-for="item in sponsors" :key="item.pathName" class="logo-item">
            <img :src="getImagePath(item.pathName)" :alt="item.name">
          </div>
        </div>
      </section>
<!--      exhibitors-->
      <section id="exhibitors" class="partner-logos" v-if="exhibitor.length != 0">
        <UsablesLandingSectionHead title="CONFERENCE EXHIBITORS" sub-title="" />
        <div class="logo-container">
          <div v-for="item in exhibitor" :key="item.pathName" class="logo-item">
            <img :src="getImagePath(item.pathName)" :alt="item.name">
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