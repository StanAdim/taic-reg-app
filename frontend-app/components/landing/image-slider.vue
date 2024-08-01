<script setup >

const eventStore = useEventStore()
const  init = async  ()=> [
    await  eventStore.handleUpComingEvents()
]
init()
onNuxtReady(() => {
  init()
});
</script>

<template>
  <div class="block text-center " >
    <h2 class="text-2xl font-bold mb-4 text-sky-600">Upcoming Events</h2>
    <div class="bg-gray-100 rounded-md mt-2.5 shadow-md md:max-h-max">
      <el-carousel :interval="5000" arrow="always" class="py-4 md:py-12">
        <el-carousel-item v-for="item in eventStore.getUpComingEvents" :key="item.id" style="height:auto">
          <div class=" my-2 mx-auto rounded ">
            <div class="">
<!--            <img src="/image/handling.png" class="w-fit" alt="img" />-->
            </div>
            <div class="text-center p-6 ">
              <div class="text-sky-600 w-full">
                <p class="text-2xl font-bold mb-5">
                  {{ item.name }} - {{ item.year }}
                </p>
              </div>
              <p class="font-light text-lg mb-2">
                {{item.theme}}
              </p>
              <p class="text-sm mb-2">

                <span class="text-blue-900">Commence date </span> <br class="block md:hidden" /><span class="text-emerald-700 font-medium"><i class="fa-solid fa-calendar-days"></i> {{item.startDate}}</span> <br>
                <span class="text-blue-900">End date </span> <br class="block md:hidden" /><span class="text-yellow-800 font-medium"><i class="fa-solid fa-calendar-xmark"></i> {{item.endDate}}</span>
              </p>
              <p class="text-sm mb-0">
                <i class="fa-solid fa-location-dot fa-lg text-sky-600 mx-1"></i>{{item.venue}}
              </p>
            </div>
              <div class="flex-1 relative md:top-2 text-center">
                <nuxt-link :to="`/crm/events/event-${item.id}`"
                           class="text-white hover:text-white bg-sky-600 my-4 hover:bg-sky-400 rounded-lg  px-5 py-2"
                >
                  Register To attend
                </nuxt-link>
            </div>
          </div>
        </el-carousel-item>
      </el-carousel>

    </div>
  </div>
</template>

<style scoped>
.carousel-item {
  color: #212b39;
  opacity: 0.75;
  margin: 0;
  text-align: center;
}

.el-carousel__item h3 {
  color: #475669;
  opacity: 0.75;
  display: flex;
  align-items: center;
  margin: 0;
  text-align: center;
  height: 100%;
}

</style>
