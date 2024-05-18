<script setup>
const scheduleStore = useScheduleStore()
const props = defineProps({
    passedSchedule: {
        type:String,
        default: null
    },
    showStatus:{
        type: Boolean,
        default:false
    }
})
const closeModal = ()=> {
    scheduleStore.toggleScheduleModal('close')
}
</script>
<template>
<div class="fixed z-20 inset-0 overflow-y-auto mt-1" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center">
        <div class="relative bg-blue-100 w-4/5 rounded-lg shadow-xl py-2">
            <div class="border-b-2 border-teal-500">
                <div  class=" bg-blue-50 py-2 block text-xl font-bold text-blue-600 text-center">SCHEDULE FOR DAY {{props.passedSchedule?.label}} OF {{ props.passedSchedule?.conferenceYear }} CONFERENCE
                    <span v-if="!props.passedSchedule?.is_visible" class="bg-blue-500 text-white hover:bg-blue-700 cursor-pointer py-1 px-2 rounded-full text-sm">
                        <i  class=" fa-solid fa-eye"></i></span>
                    <span v-if="props.passedSchedule?.is_visible" class="bg-gray-500 text-white hover:bg-gray-700 cursor-pointer py-1 px-2 rounded-full text-sm">
                        <i class=" fa-solid fa-eye-slash"></i></span>
                </div>
                <div class="shadow-lg rounded-lg overflow-hidden my-2">
                <table class="w-full table-fixed"  v-if="props.passedSchedule?.timetable">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="w-1/4 py-2 px-6 text-left text-gray-600 font-bold uppercase">Time</th>
                            <th class="w-1/4 py-2 px-6 text-left text-gray-600 font-bold uppercase">Activities</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white py-2">
                        <tr v-for="item in  props.passedSchedule?.timetable" :key="item?.id">
                            <td class="py-3 px-6 text-sm border-b border-gray-200">
                                {{item.startTime}} - {{item.endTime}}
                                <span v-if="!item.is_visible" class="mx-2 bg-teal-500 text-white hover:bg-teal-700 cursor-pointer py-1 px-2 rounded-full text-xs">
                                    <i  class="p-0.5 fa-solid fa-eye"></i>
                                </span>
                                <span v-if="item.is_visible" class="mx-2 bg-gray-500 text-white hover:bg-gray-700 cursor-pointer py-1 px-2 rounded-full text-xs">
                                    <i class="p-0.5 fa-solid fa-eye-slash"></i>
                                </span>
                                <span v-if="item.status == 1" class="mx-1 bg-green-500 text-white py-1 px-2 rounded-full text-xs">
                                    <i class="mx-2 fa-solid fa-circle-check"></i>
                                </span>
                                <span v-if="item.status == 2" class="mx-1 bg-teal-500 text-white py-1 px-2 rounded-full text-xs">
                                    <i class="mx-2 fa-regular fa-hourglass"></i>
                                </span>
                                <span v-if="item.status == 3" class="mx-1 bg-gray-500 text-white py-1 px-2 rounded-full text-xs">
                                    <i class="mx-2 fa-solid fa-arrows-rotate"></i>
                                </span>
                            </td>
                            <td class="py-1 px-6 border-b border-gray-200">
                                <div class="" v-for="subitem in item?.activities" :key="subitem"> 
                                    <p class="pb-1" > 
                                        <span class="text-blue-800 font-medium">{{subitem?.name}} </span>
                                        <UsablesTheDelete />
                                    </p>
                                    <p class="text-sm ml-5 pb-1" v-if="subitem?.hasMinActivity">
                                        <i class="fa-solid fa-angle-right text-sm"></i> <span class="" >{{ subitem?.minActivity }}</span>
                                    </p>
                                    <div class="ml-1 " v-if="subitem?.hasPanelist">
                                        <p class="text-blue-800">Panelist:</p>
                                        <p class="text-sm ml-8" v-for="keySpeaker in subitem.panelist" :key="keySpeaker">
                                            <ul class="" >
                                                <li ><i class="fa fa-check-square mx-1 text-blue-800"></i>{{ keySpeaker }}</li>
                                            </ul>
                                        </p>
                                        <p class="">
                                            <span class="text-blue-800"> Moderator:</span> 
                                            <span>{{ subitem?.moderator }}</span>
                                        </p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
                <div @click="closeModal" class="text-right my-2 mx-2">
                    <i class="fa-solid fa-xmark bg-red-100 text-red-600 p-2 rounded-sm"></i>
                </div>
            </div>
        
        </div>
    </div>
</div>
</template>
<style scoped>
.hide {
    display: none;
}
</style>