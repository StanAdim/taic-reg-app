<script setup>
const props = defineProps({
    info: {
        type:Object,
    }
})
const sponsorshipStore = useSponsorshipStore()
const globalData = useGlobalDataStore()
const config = useRuntimeConfig()
const apiBaseUlr = config.public.apiBaseUlr
const imageFullPath = (imgPath) => {
  if (!imgPath){
    return `/speakers/placeholder.png`
  }else {
    return `${apiBaseUlr}/${imgPath}`
  }
}
const changeVisibility = async (uuid) => {
  await sponsorshipStore.toggleSponsorVisibility(uuid)
}
</script>
<template>
<div class="flex w-64 mx-4 my-2 flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
    <div class="flex  p-2 text-sm " :class="{'justify-between': globalData.hasPermission('can_manage_site'), 'justify-center': !globalData.hasPermission('can_manage_site') }">
        <div class="hover:cursor-pointer" @click="changeVisibility(props.info?.id)" v-if="globalData.hasPermission('can_manage_site')">
            <span class="bg-emerald-200 hover:text-white hover:bg-emerald-500 p-1.5 m-0.5 rounded-md" v-if="props.info?.is_visible">shown<i  class="p-0.5 fa-solid fa-eye"></i></span>
            <span class="bg-red-200 hover:text-white hover:bg-red-500 p-1.5 m-0.5 rounded-md" v-else>hidden<i class="p-0.5 fa-solid fa-eye-slash"></i></span>
        </div>
        <div class="">
            <span class="bg-blue-700 text-white  p-1.5 m-0.5 rounded-md">
            {{props.info?.conferenceYear}} 
            </span>
        </div>
    </div>
  <div class=" mx-2 mt-2 h-40 overflow-hidden rounded-xl bg-white bg-clip-border text-gray-700 shadow-lg">
    <img :src="imageFullPath(props.info?.imgPath)" class="w-fit max-h-80" :alt="props.info?.name" />
  </div>
  <div class="p-3 text-center">
    <h4 class="mb-2 block font-sans text-2xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased">
      {{props.info?.name}}
    </h4>
    <p class="text-blue-700 p-1.5 m-0.5 rounded-md">
    {{ props.info?.conferenceName }}
    </p>
    <p class="para">
      {{props.info?.category}}
    </p>
    <small class="para">
    {{props.info?.sub_category}}
    </small>
<!--    <button @click="handleSpeakerInfo(props.info?.id)" class="hover:text-sky-600">More Details</button>-->
  </div>

</div>

</template>
<style>
.para {
  @apply block bg-gradient-to-tr from-teal-600 to-teal-400 bg-clip-text
  font-sans text-base font-medium leading-relaxed text-transparent antialiased
}
</style>
