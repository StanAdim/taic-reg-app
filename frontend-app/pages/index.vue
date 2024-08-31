<script lang="ts" setup>
definePageMeta({
  layout:'auth',
  middleware:'guest'
})

onNuxtReady(()=> {

})
</script>
<template>
  <div class="flex flex-col">
    <div class="">
      <div class="grid grid-rows-2  md:grid-cols-3 mt-10 gap-2 md:gap-6  mx-10">
        <div class="col-span-2">
          <div class="  bg-white mt-4 md:mt-4 mr-5">
            <div class="flex-col justify-center">
              <LandingImageSlider />
            </div>
        </div>
          </div>
            <LandingLogin />
      </div>
    </div>
  </div>
</template>

<style scoped>

.input-01 {

}
</style>
