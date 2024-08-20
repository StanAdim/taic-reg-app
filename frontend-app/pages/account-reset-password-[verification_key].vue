<script setup lang="ts">
definePageMeta({
  title: 'Account Verification',
  layout: 'auth',
})
const route = useRoute()
const message = ref('Verify Your Account')
const warning = ref('')
const globalStore = useGlobalDataStore()
const verificationOnSuccess = ref(false)
const authStore = useAuthStore()
const resetForm = ref({password: '', password_confirm: ''})
const handleFormSubmit = async () => {
  globalStore.toggleLocalLoaderStatus()
  if(resetForm.value.password === resetForm.value.password_confirm){
    resetForm.value.token = route.params.verification_key
    warning.value = ''
    const verifyResponse = await authStore.resetUserPassword(resetForm.value)
    if(verifyResponse.status.value === 'success'){
      message.value = 'Account verified'
      verificationOnSuccess.value = true;
    }
    console.log(resetForm.value)
    return
  }
  return warning.value = 'Password Mismatch'
}
</script>

<template>
<div class="">
  <div class="flex justify-center ">
    <div class="container">
      <div class="heading">Password Reset</div>
      <form @submit.prevent="handleFormSubmit()" class="form">
        <input required="" class="input" type="password" v-model="resetForm.password" id="password" placeholder="New Password">
        <input required="" class="input" type="password" v-model="resetForm.password_confirm" id="password_confirm" placeholder="Confirm Password">
        <p class="text-orange-600 my-2">{{warning}}</p>
        <input class="password-reset-btn" type="submit" value="Reset password">
      </form>
    </div>
  </div>
</div>
</template>

<style scoped>
.container {
  max-width: 350px;
  background: #F8F9FD;
  background: linear-gradient(0deg, rgb(255, 255, 255) 0%, rgb(244, 247, 251) 100%);
  border-radius: 40px;
  padding: 25px 35px;
  border: 5px solid rgb(255, 255, 255);
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 30px 30px -20px;
  margin: 20px;
}

.heading {
  text-align: center;
  font-weight: 900;
  font-size: 30px;
  color: rgb(16, 137, 211);
}

.form {
  margin-top: 20px;
}

.form .input {
  width: 100%;
  background: white;
  border: none;
  padding: 15px 20px;
  border-radius: 20px;
  margin-top: 15px;
  box-shadow: #cff0ff 0px 10px 10px -5px;
  border-inline: 2px solid transparent;
}

.form .input::-moz-placeholder {
  color: rgb(170, 170, 170);
}

.form .input::placeholder {
  color: rgb(170, 170, 170);
}

.form .input:focus {
  outline: none;
  border-inline: 2px solid #12B1D1;
}

.form .forgot-password {
  display: block;
  margin-top: 10px;
  margin-left: 10px;
}

.form .forgot-password a {
  font-size: 11px;
  color: #0099ff;
  text-decoration: none;
}

.form .password-reset-btn {
  display: block;
  width: 100%;
  font-weight: bold;
  background: linear-gradient(45deg, rgb(16, 137, 211) 0%, rgb(18, 177, 209) 100%);
  color: white;
  padding-block: 15px;
  margin: 20px auto;
  border-radius: 20px;
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 20px 10px -15px;
  border: none;
  transition: all 0.2s ease-in-out;
}

.form .password-reset-btn:hover {
  transform: scale(1.03);
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 23px 10px -20px;
}

.form .password-reset-btn:active {
  transform: scale(0.95);
  box-shadow: rgba(133, 189, 215, 0.8784313725) 0px 15px 10px -10px;
}

</style>