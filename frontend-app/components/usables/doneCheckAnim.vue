<script setup lang="ts">

</script>

<template>
<div class="check-body grid content-center">
  <div class="container">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
      <circle cx="256" cy="256" r="231" class="check-svg-commonds check-svg-circle"></circle>
      <path d="M120 270l96 96 170-200" class="check-svg-commonds check-svg-path"></path>
    </svg>
  </div>
</div>

</template>

<style scoped>
.check-body{
  width: 4rem;
  height: 4rem;
}
.container {
  width: 90%;
  max-width: 200px;
  aspect-ratio: 1 / 1;
}

@keyframes check-svg-path-anim {
  0%{
    stroke-dasharray:0 400;
    stroke-width:50;
  }
  to{
    stroke-dasharray:400 0;
    stroke-width:40;
  }
}
@keyframes check-svg-circle-anim {
  0%{
    stroke-dasharray:0 2023;
    stroke-width:50;
  }
  to {
    stroke-dasharray:2023 0;
    stroke-width:20
  }
}
.check-svg-commonds {
  fill:none;
  stroke:#198754;
  stroke-linecap:round;
  stroke-linejoin:round;
  stroke-width:60;
  transform-origin:50% 50%;
}
.check-svg-circle {
  stroke-dasharray: 2023;
  stroke-dashoffset: 2023;
  transform: rotate(-90deg);
  animation: 1s ease-in-out 0.5s 1 normal forwards running check-svg-circle-anim;
}
.check-svg-path {
  stroke-dasharray: 400;
  stroke-dashoffset: 400;
  animation: 0.5s ease-in-out 1s 1 normal forwards running check-svg-path-anim;
}
</style>