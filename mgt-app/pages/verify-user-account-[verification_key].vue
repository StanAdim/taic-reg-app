<script setup lang="ts">
definePageMeta({
  title: 'Account Verification',
  layout: 'auth',
})
const route = useRoute()
const message = ref('Verify Your Account')
const globalStore = useGlobalDataStore()
const verificationOnSuccess = ref(false)
const authStore = useAuthStore()
const handleAccountVerification = async () => {
  message.value = 'Verifying...'
  globalStore.toggleLocalLoaderStatus()
  const {data, error}  = await authStore.userEmailVerification(route.params.verification_key)
  console.log(data.value)
}
</script>

<template>
<div class="">
  <div class="flex justify-center ">
    <div class="card ">
      <p class="cookieHeading">{{globalStore.longName}}</p>
      <p class="cookieDescription">{{ message }}</p>
      <usables-local-loader v-if="globalStore.getLocalLoaderStatus" />
        <usables-done-check-anim v-if="verificationOnSuccess" />
        <template v-if="!globalStore.getLocalLoaderStatus">
          <p class="cookieDescription">To complete registration and  get access to events features,
            kindly verify your account by clicking the button below
          </p>
        <div class="buttonContainer">
          <button @click="handleAccountVerification()" class="acceptButton">Verify Account</button>
        </div>
        </template>


    </div>
  </div>
</div>
</template>

<style scoped>
.card {
  width: 300px;
  height: 600px;
  background-color: rgb(237, 248, 250);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px 30px;
  gap: 13px;
  overflow: hidden;
  box-shadow: 2px 2px 20px rgba(0, 0, 0, 0.062);
}

#cookieSvg {
  width: 50px;
}

#cookieSvg g path {
  fill: rgb(97, 81, 81);
}

.cookieHeading {
  font-size: 1.2em;
  font-weight: 800;
  color: rgb(26, 26, 26);
}

.cookieDescription {
  text-align: center;
  font-size: .9em;
  font-weight: 600;
  color: rgb(99, 99, 99);
}

.buttonContainer {
  display: flex;
  gap: 20px;
  flex-direction: row;
}

.acceptButton {
  width: auto;
  padding: .4rem .6rem;
  background-color: rgba(3, 135, 3, 0.9);
  transition-duration: .2s;
  color: rgb(241, 241, 241);
  cursor: pointer;
  font-weight: 600;
  border-radius: 20px;
  border: 1px solid;
}

.acceptButton:hover {
  background-color: rgba(10, 163, 10, 0.9);
  transition-duration: .2s;
  color: #323030;
  border: 1px rgba(6, 202, 6, 0.9) solid;
}
</style>