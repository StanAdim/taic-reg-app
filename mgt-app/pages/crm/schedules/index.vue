<script setup>
useHead({
    title: 'TAIC - Schedules'
})
definePageMeta({
    middleware:'auth'
})
const setAction = ref('')
const scheduleStore = useScheduleStore()
const itemToBePassed = ref({})

const handleInitializing = async ()=>{
    await scheduleStore.retriveConferenceSchedules();
}
const openDialog = (method, type) => {
    setAction.value = method
    switch(type) {
  case 'dayDialogy':
    scheduleStore.toogleDayDialog('open')
    scheduleStore.toogleTimetableDialog('close')
    scheduleStore.toogleActivityDialog('close')
    break;
  case 'timetableDialogy':
  scheduleStore.toogleTimetableDialog('open')
  scheduleStore.toogleDayDialog('close')
  scheduleStore.toogleActivityDialog('close')
    break;
  default:
  scheduleStore.toogleActivityDialog('open')
  scheduleStore.toogleDayDialog('close')
  scheduleStore.toogleTimetableDialog('close')
}

}
const handleScheduleShow = (passedItem) => {
    scheduleStore.toogleScheduleModal('open')
    itemToBePassed.value = passedItem
} 
handleInitializing()
</script>
<template>
    <div>
        <AdminThePageTitle title="SCHEDULES" />
        <AdminCreateUpdateDay :passedItem ="itemToUpdate"
                :showStatus="scheduleStore.openDayDialog"  
                :dialogAction="setAction" />
                <AdminCreateUpdateTimetable :passedItem ="itemToUpdate"
                :showStatus="scheduleStore.openTimetableDialog"  
                :dialogAction="setAction" />
                <AdminCreateUpdateActivity :passedItem ="itemToUpdate"
                        :showStatus="scheduleStore.openActivityDialog"  
                        :dialogAction="setAction" />
        <AdminScheduleModal :showStatus="scheduleStore.getScheduleModalStatus" :passedSchedule="itemToBePassed"/>
        <div class=" mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="w-full max-w-sm mx-auto px-4 py-4">
            <div class="flex justify-center items-center border-b-2 border-teal-500 py-2">
                <UsablesTheButton  @click="openDialog('create','activityDialogy')" :is-normal="true" name="Add Activity" iconClass="fa-solid fa-plus" />  
                <UsablesTheButton  @click="openDialog('create','timetableDialogy')" :is-normal="true" name="Add Timetable" iconClass="fa-solid fa-plus" />  
                <UsablesTheButton  @click="openDialog('create', 'dayDialogy')" :is-normal="true" name="Add Day" iconClass="fa-solid fa-plus" />  
            </div>
        </div>
        <ul class="flex justify-center divide-y divide-gray-300 px-4">
            <li class="mb-3 m-2"  v-if="scheduleStore.getConferenceDays">
                <div class="flex flex-initial flex-wrap justify-center" >
                    <div class=" text-gray-900 m-2" v-for="item in scheduleStore.getConferenceDays" :key="item.id">
                        <div class="flex items-center">
                            <div class="relative cursor-pointer text-blue-800">
                                <span class="absolute top-0 left-0 w-full h-full mt-1 ml-1 bg-indigo-200 rounded-lg "></span>
                                <div
                                    class="relative p-6 bg-white border-2 border-indigo-200 rounded-lg hover:scale-105 transition duration-500">
                                    <div class="flex items-center justify-evenly my-2">
                                        <div class="">
                                            <span class="text-xl text-green-950">DAY {{item.label}} <i class="text-teal-400 fa-solid fa-tag"></i></span>
                                        </div>
                                        <div class="">
                                            <span class="bg-emerald-200 hover:text-white hover:bg-emerald-500 p-1.5 m-0.5 rounded-md" v-if="!item?.is_visible">show<i  class="p-0.5 fa-solid fa-eye"></i></span>
                                            <span class="bg-red-200 hover:text-white hover:bg-red-500 p-1.5 m-0.5 rounded-md" v-if="item?.is_visible">hide<i class="p-0.5 fa-solid fa-eye-slash"></i></span>
                                        </div>
                                    </div>
                                    <p class="text-gray-900 ">
                                        Happening on <span class="text-blue-600">{{ item.date }}</span>
                                    </p>
                                    <div class="flex flex-row justify-evenly mt-2">
                                        <div class="">
                                            <h3 class="text-lg mt-2 font-bold text-gray-800 "> <span class="text-blue-600">{{ item.conferenceYear }}</span> Conference</h3>
                                        </div>
                                        <i class=""></i>
                                        <div class="ml-10">
                                            <UsablesTheButton @click="handleScheduleShow(item)" :is-normal="true" name="" iconClass="fa-solid fa-right-to-bracket" />
                                            <UsablesTheButton :is-danger="true" name="" iconClass="fa-regular fa-trash-can" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    </div>
</template>