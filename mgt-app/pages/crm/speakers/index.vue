<script setup>
useHead({
    title: 'TAIC - Speakers'
})
definePageMeta({
    middleware:'auth'
})
const globalData = useGlobalDataStore()
const confSpeaker = ref([
    {   name: 'James Askari',
        email: 'james@mail.com',
        designation: 'Director',
        institution: 'Askari Mtaa',
        linkedinLink: '#....',
        twitterLink: '#....',
        isMain: false,
        conference_id: '___',
        imgPath: '/team/placeholder2.png',
        is_visible: true
    },
    {   name: 'Harris Kundi Malafyalekise',
        email: 'harris@mail.com',
        designation: 'Chief Executive',
        institution: 'Ndani Parmount',
        linkedinLink: '#....',
        twitterLink: '#....',
        isMain: false,
        conference_id: '___',
        imgPath: '/team/placeholder2.png',
        is_visible: false
    },
    {   name: 'Henry Stanley',
        email: 'henry@mail.com',
        designation: 'Managing Director',
        institution: 'Poontana Technologies',
        linkedinLink: '#....',
        twitterLink: '#....',
        isMain: false,
        conference_id: '___',
        imgPath: '/team/placeholder2.png',
        is_visible: true
    },
   
])
const keySpeakerStore = useSpeakerStore()
const itemToUpdate = ref(null)
const setAction = ref('')
const handleInitializing = async ()=>{
    keySpeakerStore.retriveConferenceSpeakers()
}
const openDialog = (method)=>{
    setAction.value = method
    keySpeakerStore.toogleDialog('open');
    // console.log(method);
}
handleInitializing()
</script>
<template>
        <AdminThePageTitle title="KEY SPEAKERS" />
        <AdminCreateUpdateKeySpeaker :passedItem ="itemToUpdate"
    :showStatus="keySpeakerStore.openKeySpeakDialog"  
    :dialogAction="setAction" />
    <div class="">
        <div class=" mx-auto bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="w-full max-w-sm mx-auto px-4 py-4">
            <div class="flex justify-center items-center border-b-2 border-teal-500 py-2">
                <UsablesTheButton @click="handleInitializing()" :is-normal="true" name="Refresh" iconClass="fa-solid fa-arrows-rotate" />
                <UsablesTheButton  @click="openDialog('create')" :is-normal="true" name="Add Speaker" iconClass="fa-solid fa-plus" />  
            </div>
        </div>
        <ul class="flex justify-center divide-y divide-gray-300 px-4">
            <li class="mb-3 mt-2" >
                <div class="flex flex-initial flex-wrap" v-if="keySpeakerStore.getSpeakers">
                    <div class=" text-gray-900 " v-for="item in keySpeakerStore.getSpeakers" :key="item.email">
                        <AdminSpeakerCard :info="item" />
                    </div>

                </div>
            </li>
        </ul>
    </div>
    </div>
</template>