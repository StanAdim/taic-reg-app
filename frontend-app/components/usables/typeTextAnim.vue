<script setup lang="ts">

const props = defineProps({
  dataText:{
    default: ['Welcome to ICT Commission event Management Dashboard'],
    type: Array
  }
})

const textShow = ref('Hello')
function typeWriter(text, i, fnCallback) {
  if (i < (text.length)) {
    textShow.value = text.substring(0, i+1) +'';
    setTimeout(function() {
      typeWriter(text, i + 1, fnCallback)
    }, 200);
  }
  else if (typeof fnCallback == 'function') {
    setTimeout(fnCallback, 300);
  }
}
function StartTextAnimation(i) {
  if (typeof props.dataText[i] == 'undefined'){
    setTimeout(function() {
      StartTextAnimation(0);
    }, 5000);
  }
  if (i < props.dataText.length) {
    // text exists! start typewriter animation
    typeWriter(props.dataText[i], 0, function(){
      // after callback (and whole text has been animated), start next text
      StartTextAnimation(i + 1);
    });
  }
}
// start the text animation
StartTextAnimation(0)
</script>

<template>
  <p class="mx-2 "> {{textShow}} <span aria-hidden="false"></span></p>

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