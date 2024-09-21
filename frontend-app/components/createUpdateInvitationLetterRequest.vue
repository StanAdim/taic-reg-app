<script setup>
const authStore = useAuthStore()

// Props for the component
const props = defineProps({
  invitationRequest: {
    type: Object,
    default: () => ({
      id: '',
      institutionName: '',
      addressingTo: '',
      po_box: '',
      hostPosition: '',
      email_to: '',
      conference_id: 0,
      region_Id: 0,
      status: false,
      user_id: 0
    })
  },
  isUpdateMode: {
    type: Boolean,
    default: false
  },
  showStatus: {
    type: Boolean,
    default: false
  }
})
const invitationStore = useInvitationStore()
const eventStore = useEventStore()
const globalStore = useGlobalDataStore()
// Reactive form data initialized from props
const formData = reactive({
  id: props.invitationRequest.id,
  institutionName: authStore.getLoggedUserInfo?.institution,
  email_to: props.invitationRequest.email_to,
  addressingTo: props.invitationRequest.addressingTo,
  po_box: props.invitationRequest.po_box,
  hostPosition: props.invitationRequest.hostPosition,
  conference_id: props.invitationRequest.conference_id,
  region_Id: props.invitationRequest.region_Id,
})
// Handle form submission
const handleSubmit = async () => {
  globalStore.toggleBtnLoadingState(true)
  try {
    if (props.isUpdateMode) {
      // Update mode: send PUT request
      await  invitationStore.createInvitationRequest(formData);
    } else {
      // Create mode: send POST request
       await  invitationStore.createInvitationRequest(formData);
    }
  } catch (error) {
    console.error('Error submitting form:', error)
  }
  await closeModal()
}
const closeModal = async ()=> {
   await  invitationStore.retrieveAllInvitationRequests();
  invitationStore.toggleNewInvitationModalStatus(false)
}
</script>
<template>
  <div class="fixed z-20  inset-0 overflow-y-auto rounded-lg mt-32bg-black bg-opacity-60" :class="{'hide': !props.showStatus}" id="modal">
    <div class="flex  justify-center align-middle ">
      <div class="bg-blue-100 rounded-lg px-2 shadow-xl md:p-4">
        <div class="border-b-2 border-teal-500">
          <div class="border-b-2 border-teal-500 py-0.5 flex justify-between items-center">
          <span class="text-emerald-800 p-0.5 bg-zinc-50/5 flex-shrink-0">
            <i class="fa fa-xl  fa-user mx-2"></i>
          </span>
            <span class="text-emerald-800 my-2 p-0.5 bg-zinc-50/5 flex-grow text-xl text-center font-bold">
             INVITATION LETTER REQUEST FORM
          </span>
            <span class="text-emerald-800 p-0.5 bg-zinc-50/5 rounded-md hover:bg-red-500 hover:text-white flex-shrink-0"
                  @click="closeModal()"
            >
            <i class="fa-solid  fa-xl fa-xmark mx-2"></i>
          </span>
          </div>
          <!-- component -->
          <div class="max-w-lg mx-auto p-6 bg-white rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-center">
              {{ isUpdateMode ? 'Update Request' : 'Create Request' }}
            </h2>
            <form @submit.prevent="handleSubmit">
              <!-- Name Input -->
              <div class="mb-4">
                <label for="name" class="input-label">Name of Institution| Company</label>
                <input
                    v-model="formData.institutionName"
                    type="text"
                    id="name"
                    class="input-form"
                    placeholder="Company | Institution name"
                    required
                />
              </div>

              <div class="mb-4">
                <label for="email_to" class="input-label">Receiving Email</label>
                <input
                    v-model="formData.email_to"
                    type="email"
                    id="email_to"
                    class="input-form"
                    placeholder="Company | Institution name | Your Email"
                    required
                />
              </div>

              <!-- Size Input -->
              <div class="mb-4">
                <label for="size" class="input-label">Address To </label>
                <input
                    v-model="formData.addressingTo"
                    type="text"
                    id="size"
                    class="input-form"
                    placeholder="Eg. DG, CEO"
                    required
                />
              </div>
              <div class="mb-4">
                <label for="hostPosition" class="input-label">Your position </label>
                <input
                    v-model="formData.hostPosition"
                    type="text"
                    id="hostPosition"
                    class="input-form"
                    placeholder="Your designation"
                    required
                />
              </div>
              <div class="mb-4">
                <label for="poBox" class="input-label">Office PO BOX</label>
                <input
                    v-model="formData.po_box"
                    type="text"
                    id="poBox"
                    class="input-form"
                    placeholder="Eg PO.Box 222"
                    required
                />
              </div>
              <div class="mb-4">
                <label for="region_Id" class="input-label">Region </label>
                <select
                    v-model="formData.region_Id"
                    id="region_Id"
                    class="input-form"
                    required
                >
                  <option value="0" disabled>Select Region</option>
                  <option :value="item.id" v-for="item in globalStore.getRegions " :key="item">{{item.name}}</option>
                </select>
              </div>

              <div class="mb-4">
                <label for="conference_id" class="input-label">Conference | Event </label>
                <select
                    v-model="formData.conference_id"
                    id="conference_id"
                    class="input-form"
                    required
                >
                  <option value="0" disabled>Select conference</option>
                  <option :value="item.id" v-for="item in eventStore.getEvents " :key="item">{{item.name}}</option>
                </select>
              </div>

              <div class="text-center">
                <button
                    type="submit"
                    class="submit-btn"
                >
                  {{ isUpdateMode ? 'Update' : 'Submit' }} Request <UsablesBtnLoader />
                </button>
              </div>
            </form>
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
.submit-btn {
  @apply w-full px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500
}
.input-label {
  @apply block text-sm font-medium text-gray-700 mb-1
}
.input-form {
  @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500
}
</style>