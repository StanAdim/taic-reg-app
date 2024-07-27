<script setup >

const eventStore = useEventStore()
const  init = async  ()=> [
    await  eventStore.handleUpComingEvents()
]
init()
</script>

<template>
  <div class="block text-center" style="height: 300px">
    <h2 class="text-xl font-bold my-2 text-sky-600">Upcoming Events</h2>
    <div class="bg-gray-100 rounded-md mt-2.5 shadow-md">
      <el-carousel :interval="5000" arrow="always">
        <el-carousel-item v-for="item in eventStore.getUpComingEvents" :key="item.id" style="height:auto">
          <div class=" my-2 mx-auto rounded ">
            <div class="">
              <!--              <img src="/image/handling.png" class="w-fit" alt="img" />-->
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

                <span class="text-blue-900">Commence on : </span><span class="text-emerald-700 font-medium"><i class="fa-solid fa-calendar-days"></i> {{item.startDate}}</span> <br>
                <span class="text-blue-900">End on: </span><span class="text-yellow-800 font-medium"><i class="fa-solid fa-calendar-xmark"></i> {{item.startDate}}</span>
              </p>
              <p class="text-sm mb-0">
                <i class="fa-solid fa-location-dot fa-lg text-sky-600 mx-1"></i>{{item.venue}}
              </p>
            </div>
            <div class="border-t border-gray-300 mt-10 flex justify-center p-0">
              <div class="flex-1 text-center">
                <nuxt-link :to="`/crm/events/event-${item.id}`"
                           class="text-blue-800 hover:text-white bg-sky-300 my-2 hover:bg-sky-600 rounded-bl-md w-full px-2 py-1"
                >
                  Register To attend
                </nuxt-link>
              </div>
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
