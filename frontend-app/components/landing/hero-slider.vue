
<script lang="ts" setup>


const images = ref([
    'landing-page.jpg',
    'landing-page.jpg',
    'landing-page.jpg',
])
const imgPath = (imageName:string)=> `image/sliders/${imageName}`
onNuxtReady(()=> {

})
</script>
<template>
  <div class="block text-center">
    <el-carousel trigger="click" >
      <el-carousel-item v-for="item in images" :key="item">
<!--        <h3 class="small justify-center" text="2xl">{{ imgPath(item) }} </h3>-->
        <el-image style="width: auto;" :src="imgPath(item)" :fit="fit" />
      </el-carousel-item>
    </el-carousel>
  </div>
</template>

<style scoped>

 img {
  width: 100%; /* Make the image fill the width of the container */
  height: auto; /* Maintain the image's aspect ratio */
  object-fit: cover; /* Ensure the image covers the container (optional, based on your need) */
}

</style>
