<script setup>
definePageMeta({
    middleware:'auth'
})
useHead({
    title: 'TAIC - App Configuration'
})
const conferences = ref([])
const globalStore = useGlobalDataStore()
const configStore = useEventStore()
const setAction = ref('create')
const itemToUpdate = ref({})
const openDialog = (method, passedItem = '' )=>{
    itemToUpdate.value = passedItem
    setAction.value = method
    configStore.toogleDialog()
}
async function handleCall(){
    globalStore.setLoadingTo('on')
    await configStore.retriveConferences()

}
handleCall();

</script>
<template>
<div>
    <AdminThePageTitle title="Conferences" />
    <adminCreateUpdateConference :passedItem ="itemToUpdate"
    :showStatus="configStore.configurationDialogStatus"  
    :configurationAction="setAction"/>
    <div class="">
        <div class=" mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="w-full max-w-sm mx-auto px-4 py-2">
            <div class="flex justify-center items-center border-b-2 border-teal-500 py-2">
                <UsablesTheButton  @click="handleCall()" :is-normal="true" name="Refresh" iconClass="fa-solid fa-arrows-rotate" />  
                <UsablesTheButton  @click="openDialog('create', '')" :is-normal="true" name="Add Conference" iconClass="fa-solid fa-plus" />  
            </div>
        </div>
        <ul class="divide-y divide-gray-300 px-4" v-if="configStore.getConferences">
            <li class="mb-3 mt-0.5" v-for="item in configStore.getConferences" :key="item">
                <div class="flex flex-md-column mt-3">
                    <div class="ml-3 text-gray-900 block">
                        <p 
                        class=" bg-blue-200 mt-0.5 my-0.5 py-1 px-4 rounded-sm pl-4 text-lg text-sky-900 font-bold">
                        TAIC 
                        <span class="text-lg font-medium text-sky-900">{{item?.conferenceYear}}</span>
                        <span v-if="item?.lock" class=" ml-4 text-xl text-orange-700 text-right"><small class=" small">Active</small><i class="fa-solid fa-cloud-arrow-up fa-l mx-2"></i></span>
                     </p>
                    </div>
                    <div class="ml-3 block text-teal-900">
                        <p class="my-0.5 py-0 font-medium line-clamp-1	">{{ item.theme }}</p>
                        <span class="text-sm mx-3 font-medium text-gray-500">Commence on <span class="text-blue-600">{{item.startDate}}</span></span>
                        <span class="text-sm mx-3 font-medium text-gray-500">Due on <span class="text-orange-700">{{item.endDate}}</span></span>
                    </div>
                    <div class="ml-3 block text-teal-900">
                        <p class="my-0.5 py-0 text-lg text-sky-800 font-medium">Fees</p>
                        <span class="mx-3 font-medium">Default: <em class="">{{ item.defaultFee }} Tsh</em></span>
                        <span class="mx-3 font-medium">Guest: <em class="">{{ item.guestFee }} Tsh</em></span>
                        <span class="mx-3 font-medium">Foreigner: <em class="">{{ item.foreignerFee }} $</em></span>
                    </div>

                    <div class="mt-2 flex justify-end">
                        <button @click="openDialog('update', item.id)"
                            class="mx-1 flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 
                            hover:border-teal-700 text-sm border-4 text-white py-0.5 px-2 rounded"
                            type="button">
                            Edit <i class="fa-regular fa-pen-to-square mx-2"></i>
                        </button>
                        <button @click="configStore.handleConferenceActivation(item.id)"
                            class="mx-1 flex-shrink-0 bg-sky-500 hover:bg-sky-700 border-sky-500 
                            hover:border-sky-700 text-sm border-4 text-white py-0.5 px-2 rounded"
                            type="button">
                            Activate <i class="fa-brands fa-creative-commons-sampling"></i>
                        </button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    </div>
</div>
</template>