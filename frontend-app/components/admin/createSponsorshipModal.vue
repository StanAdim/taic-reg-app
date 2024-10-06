<script  setup lang="ts">
const props = defineProps({
  isUpdateMode: {
    type: Boolean,
    default: false
  }
})

const sponsorshipStore = useSponsorshipStore()
const eventStore = useEventStore()
const globalStore = useGlobalDataStore()
const formInputs = reactive({
  conference_id:0,
  name: '',
  category: '',
  sub_category: '',
  imgPath: '',
})
let action = 'create'
const handleFileChange = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files[0]) {
    formInputs.imgPath = target.files[0];
  }
};
const handleForm = async ()=> {
    if(props.dialogAction === 'update'){
        // formData.id = props.passedItem
    }
  if (!formInputs.imgPath) {
    const message = 'Please select a Image to upload.';
    globalStore.assignAlertMessage(message, 'warning');
    return;
  }
  // Create FormData
  const formData = new FormData();
  formData.append('imgPath', formInputs.imgPath);
  formData.append('name', formInputs.name);
  formData.append('conference_id', formInputs.conference_id);
  formData.append('category', formInputs.category);
  formData.append('sub_category', formInputs.sub_category);

  globalStore.toggleBtnLoadingState(true)
   await sponsorshipStore.createUpdateSponsor(formData, action)
}
function initDialogData() {
  console.log('edit mode')
  formInputs.id = sponsorshipStore.getSponsorTobeEdited?.id
  formInputs.name = sponsorshipStore.getSponsorTobeEdited?.name
  formInputs.category = sponsorshipStore.getSponsorTobeEdited?.category
  formInputs.sub_category = sponsorshipStore.getSponsorTobeEdited?.sub_category
  formInputs.conference_id = sponsorshipStore.getSponsorTobeEdited?.conference_id
  formInputs.imgPath = sponsorshipStore.getSponsorTobeEdited?.imgPath

}

const categories = [
  {id : 1 , name : 'Sponsor'},
  {id : 2 , name : 'Partner'},
  {id : 3 , name : 'Exhibitor'},
]
const subcategories = [
  {id : 1 , name : 'Main'},
  {id : 2 , name : 'Platinum'},
  {id : 3 , name : 'Silver'},
  {id : 4, name : 'Silver'},
  {id : 5, name : 'None'},
]
defineExpose({
  initDialogData
});
</script>
<template>
    <div class="fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-80" v-if="sponsorshipStore.getSponsorModalStatus" id="modal">
        <div class="flex items-center justify-center min-h-screen">
            <div class="relative bg-white w-3/5 rounded-lg shadow-xl p-8">
                <h2 class="text-xl font-semibold mb-4 text-center capitalize">{{props.dialogAction}} Conference Sponsorship</h2>
        <form @submit.prevent="handleForm()">
            <div class="form-section">
                <label for="selectedConference" class="form-labels">Select Conference</label>
                <select id="selectedConference" v-model="formInputs.conference_id"  class="form-input">
                    <option value="0" disabled>Choose conference</option>
                    <option v-for="conference in eventStore.getEvents"
                            :key="conference" :value="conference.id">{{conference.name + ' - '+ conference.year}}</option>
                </select>
            </div>
            <div class="flex flex-row justify-evenly">
                <div class="form-section w-3/4 mx-2">
                    <label for="name" class="form-labels">Name</label>
                    <input class="form-input"
                    type="text" v-model="formInputs.name" placeholder="Sponsors Company name" id="name">
                </div>
                <div class="form-section w-3/4 mx-2">
                  <label for="selectCat" class="form-labels">Select Category</label>
                  <select id="selectCat" v-model="formInputs.category"  class="form-input">
                    <option value="0" disabled>Choose category</option>
                    <option v-for="item in categories"
                            :key="item?.id" :value="item?.name">{{item?.name}}</option>
                  </select>
                </div>
            </div>
          <div class="form-section" v-if="formInputs.category === 'Sponsor'">
            <label for="selectSubCat" class="form-labels">Select Sub Category</label>
            <select id="selectSubCat" v-model="formInputs.sub_category"  class="form-input">
              <option value="0" disabled>Choose sub category</option>
              <option v-for="item in subcategories"
                      :key="item?.id" :value="item?.name">{{item?.name }}</option>
            </select>
          </div>
            <div class="mb-2 border-b-2 border-teal-500 py-2">
                <div class="col-span-full">
                    <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Passport Photo</label>
                    <div class="mt-2 bg-stone-100 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-2 py-4">
                    <div class="text-center">
                        <span class="mx-auto h-6 w-6 text-gray-300"><i class="fa-solid fa-upload fa-3x"></i></span>
                        <div class="mt-4 flex text-sm leading-6 text-gray-600">
                        <label for="file-upload" class="relative cursor-pointer rounded-md p-2 bg-white font-semibold text-teal-600 
                        focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-teal-500">
                            <span>{{formInputs.imageFile?.name || 'Upload a passport size img'}}</span>
                            <input id="file-upload" name="path" type="file" class="sr-only"
                                   accept=""
                                   @change="handleFileChange"
                            />
                        </label>
                        </div>
                        <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                    </div>
                    </div>
                </div>
            </div>
        <div class="mt-6">
          <button class="bg-green-500 text-white px-4 py-0.5 mx-3  rounded-md hover:bg-green-600">Save <i class="fa-regular fa-floppy-disk mx-2"></i>
            <span class="px-2"><UsablesBtnLoader /></span>
          </button>
          <button @click="sponsorshipStore.toggleSponsorModal(false)" class="flex-shrink-0 bg-gray-500 hover:bg-gray-700 border-gray-500
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
.form-section {
  @apply mb-4 border-b-2 border-teal-500 py-2
}
.form-labels {
  @apply block text-sm font-medium text-gray-700 ;
}
.form-input {
  @apply appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none
}
</style>