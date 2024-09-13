<script setup lang="ts">
const props = defineProps({
  requestData: {
    type: Object,
    default: () => ({
      id: '',
      subject: '',
      message: '',
      responses: [],
    })
  },
})
const authStore = useAuthStore()
const formatDate = (date)  =>{
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(date).toLocaleDateString(undefined, options);
}
 const capitalize = (string) => {
  if(string){
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
}
</script>

<template>
      <div class="">
        <div class="mb-6">
          <nuxt-link v-if="authStore.getUserRole === 'admin'" :to="`/crm/support/request-${props.requestData?.id}`">
            <h2 class="text-2xl text-blue-600 font-semibold mb-2">{{capitalize(props.requestData?.subject)}}</h2>
          </nuxt-link>
          <h2 v-else class="text-2xl text-blue-600 font-semibold mb-2">{{capitalize(props.requestData?.subject)}}</h2>

          <p v-if="authStore.getUserRole === 'admin'" class="text-sm text-gray-600">Submitted by:
            <nuxt-link :to="`/crm/users/user/${props.requestData?.userKey}`">{{ props.requestData?.user }}</nuxt-link>
          </p>
          <p class="text-sm text-gray-600 mt-1">Status: <span class="text-green-500 px-2">{{props.requestData?.status}}</span>
            <span class="ml-auto text-sm text-gray-500 sm:ml-0 sm:mt-0 mt-2">Posted on: {{ formatDate(props.requestData?.created_at) }}</span>
          </p>
          <p class="font-bold mt-4">Raise Issue Message</p>
          <p class="text-gray-700">{{props.requestData?.message}}</p>

        </div>
        <div>
          <h3 class="text-xl font-semibold mb-4 px-2 relative">Responses </h3>

          <!--   block for each response -->
          <template v-if="props.requestData?.responses.length != 0">
            <div v-for="item in props.requestData?.responses" class="mb-6 bg-emerald-50 border-b border-gray-200 py-2 px-3 rounded-lg">
              <div class="flex flex-col sm:flex-row items-start sm:items-center mb-2">
<!--                response by // user-->
                <span class="text-sm text-gray-600 mx-2">{{ item?.responder }}</span>
                <span class="ml-auto text-sm text-gray-500 sm:ml-0 sm:mt-0 mt-2">Posted on: {{ formatDate(item?.created_at) }}</span>
              </div>
<!--             response message-->
              <p class="text-gray-700">{{ item?.response }}</p>
            </div>
          </template>
        </div>
      </div>
</template>

<style scoped>

</style>