<script  setup>
const props = defineProps({
    passedItem:{
        type:String,
        default: null
    },
    dialogAction: {
        type: String,
        default: 'create'
    },
    showStatus:{
        type: Boolean,
        default: false
    }
})

const keySpeakerStore = useSpeakerStore()

const configStore = useConfigurationStore()
const globalStore = useGlobalDataStore()
const formData = ref({
})
const initialize = async ()=> {
    await configStore.retriveConferences();
}
const handleForm = async ()=> {
    globalStore.setLoadingTo('on')
    if(props.dialogAction == 'update'){
        formData.value.id = props.passedItem
    }
    formData.value.action = props.dialogAction
    const {error}  = await keySpeakerStore.createUpdateSpeaker(formData.value)
    console.log(error.value)
    formData.value = {}
}
initialize()
</script>
<template>
    <div class="fixed z-10 inset-0 overflow-y-auto" :class="{'hide': !props.showStatus}" id="modal">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative bg-white w-3/5 rounded-lg shadow-xl p-8">
                <h2 class="text-xl font-semibold mb-4 text-center capitalize">{{props.dialogAction}} Conference Configuration</h2>
        <form @submit.prevent="handleForm()">
            <pre>{{ props.passedItem }}</pre>
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <label for="StartDate" class="block text-sm font-medium text-gray-700">Select Conference</label>
                <select v-model="formData.conference_id" id="" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                    <option value="conference" disabled>Choose Year</option>
                    <option v-for="conference in configStore.getConferences" :key="conference" :value="conference.id">{{conference.conferenceYear}}</option>
                </select>
            </div>
            <div class="flex flex-row justify-evenly">
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text" v-model="formData.name" placeholder="Speaker full name" id="name">
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text" v-model="formData.email" placeholder="speaker email" id="email">
                </div>
            </div>
            <div class="flex flex-row justify-evenly">
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="institution" class="block text-sm font-medium text-gray-700">Institution | Company</label>
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text" v-model="formData.institution" placeholder="Speaker institution" id="institution">
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="designation" class="block text-sm font-medium text-gray-700">Designation</label>
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text" v-model="formData.designation" placeholder="Speaker designation" id="designation">
                </div>
            </div>
            <div class="flex flex-row justify-evenly">
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="linkedinLink" class="block text-sm font-medium text-gray-700">Linkedin</label>
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text" v-model="formData.linkedinLink" placeholder="Add a Conference linkedinLink" id="linkedinLink">
                </div>
                <div class="mb-4 border-b-2 border-teal-500 py-2 w-3/4 mx-2">
                    <label for="twitterLink" class="block text-sm font-medium text-gray-700">X-Link | Twitter</label>
                    <input class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
                    type="text" v-model="formData.twitterLink" placeholder="Add a Conference twitterLink" id="twitterLink">
                </div>
            </div>
            <div class="mb-4 border-b-2 border-teal-500 py-2">
                <div class="col-span-full">
                    <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Passport Photo</label>
                    <div class="mt-2 bg-stone-100 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                    <div class="text-center">
                        <span class="mx-auto h-12 w-12 text-gray-300"><i class="fa-solid fa-upload fa-3x"></i></span>
                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer rounded-md p-2 bg-white font-semibold text-teal-600 
                        focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-teal-500">
                            <span>Upload a passport size img</span>
                            <input id="file-upload" name="file-upload" type="file" class="sr-only" />
                        </label>
                        </div>
                        <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                    </div>
                    </div>
                </div>
            </div>
        <div class="mt-6">
          <button class="bg-green-500 text-white px-4 py-0.5 mx-3  rounded-md hover:bg-green-600">Save <i class="fa-regular fa-floppy-disk mx-2"></i></button>
          <button @click="keySpeakerStore.toogleDialog('close')" class="flex-shrink-0 bg-gray-500 hover:bg-gray-700 border-gray-500
                    hover:border-teal-700 text-sm border-4 text-white py-0.5 px-4 rounded"
                type="button">
                Close <i class="fa-regular fa-circle-xmark mx-2"></i>
            </button>
        </div>
      </form>
    </div>
  </div>
</div>

</template>
<style scoped>
.hide {
    display: none;
}
</style>