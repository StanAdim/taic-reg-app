<script setup lang="ts">

// State for modal visibility
const userStore = useUserStore()

// Form data (initialize empty)
const form = ref({
  DateOfRegistration: '',
  RegNo: '',
  Name: '',
  Employer: '',
  ProfessionalCategory: null,
  AreaOfSpecialization: '',
  Email: '',
  Mobile: '',
  Gender: '',
  Region: ''
});

const closeModal = () => {
  userStore.toggleRegModalStatus(false)
};

// Function to handle form submission
const submitForm = async () => {
  try {
    // Replace with actual submission logic (e.g., API call)
    await userStore.store(form.value)
    console.log('Form submitted:', form.value);

    // Optionally reset form
    Object.keys(form.value).forEach((key) => {
      form.value[key] = '';
    });
    // Close the modal
    closeModal();
    // Optionally, navigate or show success message
    // router.push({ name: 'SuccessPage' });
  } catch (error) {
    console.error('Error submitting form:', error);
  }
};
</script>
<template>
  <div>
    <!-- Modal Background -->
    <div
        v-if="userStore.getRegModalStatus"
        class="fixed inset-0 md:flex md:items-center md:justify-center bg-black bg-opacity-60 z-10"
    >
      <!-- Modal Content -->
      <div class="bg-white md:w-1/3 w-72 mx-2 p-6 rounded-lg shadow-lg">
        <!-- Modal Header -->
        <div class="flex justify-between items-center pb-4 border-b">
          <h2 class="text-xl font-bold">Add New Professional Data</h2>
          <button @click="closeModal" class="text-gray-500 hover:text-gray-800">
            &times;
          </button>
        </div>

        <!-- Form -->
        <form @submit.prevent="submitForm">
          <div class="mb-4">
            <label for="DateOfRegistration" class="block text-gray-700">Date of Registration</label>
            <input
                type="date"
                v-model="form.DateOfRegistration"
                class="input-form"
                required
            />
          </div>

          <div class="mb-4">
            <label for="RegNo" class="block text-gray-700">Registration Number</label>
            <input
                type="text"
                v-model="form.RegNo"
                class="input-form"
                required
            />
          </div>

          <div class="mb-4">
            <label for="Name" class="block text-gray-700">Name</label>
            <input
                type="text"
                v-model="form.Name"
                class="input-form"
                required
            />
          </div>

          <div class="mb-4">
            <label for="Employer" class="block text-gray-700">Employer</label>
            <input
                type="text"
                v-model="form.Employer"
                class="input-form"
            />
          </div>
          <div class="mb-4">
            <label for="ProfessionalCategory" class="block text-gray-700">Professional Category</label>
            <select
                v-model="form.ProfessionalCategory"
                class="input-form"
                required
            >
              <option value="">Select Gender</option>
              <option value="1">Professional</option>
              <option value="2">Technician</option>
              <option value="3">Graduate</option>
              <option value="4">Affiliate</option>
              <option value="5">Consultant</option>
            </select>
          </div>
          <div class="mb-4">
            <label for="AreaOfSpecialization" class="block text-gray-700">Area of Specialization</label>
            <input
                type="text"
                v-model="form.AreaOfSpecialization"
                class="input-form"
            />
          </div>
          <div class="mb-4">
            <label for="Email" class="block text-gray-700">Email</label>
            <input
                type="email"
                v-model="form.Email"
                class="input-form"
                required
            />
          </div>

          <div class="mb-4">
            <label for="Mobile" class="block text-gray-700">Mobile</label>
            <input
                type="text"
                v-model="form.Mobile"
                class="input-form"
                required
            />
          </div>

          <div class="mb-4">
            <label for="Gender" class="block text-gray-700">Gender</label>
            <select
                v-model="form.Gender"
                class="input-form"
                required
            >
              <option value="">Select Gender</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="mb-4">
            <label for="Region" class="block text-gray-700">Region</label>
            <input
                type="text"
                v-model="form.Region"
                class="input-form"
                required
            />
          </div>

          <!-- Modal Footer -->
          <div class="flex justify-end">
            <button
                type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded"
            >
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.input-form {
  @apply w-full p-2 border border-gray-300 rounded mt-1
}
/* Custom styles for the modal can go here if needed */
</style>
