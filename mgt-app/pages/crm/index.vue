<script setup>
definePageMeta({
  middleware: 'auth'
})
const authStore = useAuthStore()
const globalStore = useGlobalDataStore()
const textShow = ref('Hello')
const dataText = ['Welcome to Dashboard']
function typeWriter(text, i, fnCallback) {
  if (i < (text.length)) {
   textShow.value = text.substring(0, i+1) +'';
    setTimeout(function() {
      typeWriter(text, i + 1, fnCallback)
    }, 100);
  }
  else if (typeof fnCallback == 'function') {
    setTimeout(fnCallback, 700);
  }
}
function StartTextAnimation(i) {
  if (typeof dataText[i] == 'undefined'){
    setTimeout(function() {
      StartTextAnimation(0);
    }, 5000);
  }
  if (i < dataText.length) {
    // text exists! start typewriter animation
    typeWriter(dataText[i], 0, function(){
      // after callback (and whole text has been animated), start next text
      StartTextAnimation(i + 1);
    });
  }
}
// start the text animation
StartTextAnimation(0)

</script>
<template>
  <div>
    <AdminThePageTitle title="APP DASHBOARD" />
    <!-- component -->
            <p class="mx-2 "> {{textShow}} <span aria-hidden="false"></span></p>

  </div>
</template>
<style scoped>
span {
  border-right: .1em solid;
  animation: caret 1s steps(1) infinite;
}
@keyframes caret {
  50% {
    border-color: transparent;
  }
}
</style>