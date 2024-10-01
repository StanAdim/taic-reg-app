<script setup>
const props = defineProps({
    info: {
        type:Object,
    }
})
const config = useRuntimeConfig()
const apiBaseUlr = config.public.apiBaseUlr
const imageFullPath = (imgPath) => `${apiBaseUlr}/${imgPath}`
</script>
<template>
<!-- component -->
<div class="flex w-64 mx-4 my-2 flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
    <div class="flex justify-between p-2 text-sm ">
        <div class="">
            <span class="bg-emerald-200 hover:text-white hover:bg-emerald-500 p-1.5 m-0.5 rounded-md" v-if="!props.info?.is_visible">show<i  class="p-0.5 fa-solid fa-eye"></i></span>
            <span class="bg-red-200 hover:text-white hover:bg-red-500 p-1.5 m-0.5 rounded-md" v-if="props.info?.is_visible">hide<i class="p-0.5 fa-solid fa-eye-slash"></i></span>
        </div>
        <div class="">
            <span class="bg-blue-700 text-white  p-1.5 m-0.5 rounded-md">
            {{props.info?.conferenceYear}} 
            </span>
        </div>
        <div class=" bg-emerald-200 hover:text-white hover:bg-emerald-500 p-1 rounded-md">GoH<i class="mx-0.5 fa-brands fa-creative-commons-sampling"></i></div>
    </div>
  <div class=" mx-2 mt-2 h-40 overflow-hidden rounded-xl bg-white bg-clip-border text-gray-700 shadow-lg">
    <img :src="imageFullPath(props.info?.imgPath)" :alt="props.info?.name" />
  </div>
  <div class="p-3 text-center">
    <h4 class="mb-2 block font-sans text-2xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased">
      {{props.info?.name}}
    </h4>
    <p class="block bg-gradient-to-tr from-pink-600 to-pink-400 bg-clip-text 
    font-sans text-base font-medium leading-relaxed text-transparent antialiased">
    {{props.info?.designation}} 
    </p>
    <small class="block bg-gradient-to-tr from-pink-600 to-pink-400 bg-clip-text 
    font-sans text-base font-medium leading-relaxed text-transparent antialiased">
    {{props.info?.institution}}
    </small>
   
  </div>

</div>

</template>
