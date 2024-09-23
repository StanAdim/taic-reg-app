
<script lang="ts" setup>
const option = {
  fullScreen: {
    enable: false,
  },
  particles: {
    color: {
      // value: "#4aafdb",
      // value: "#38bdf8",
      value: "#31b5ed",
    },
    opacity: {
      value: 0.6,
      random: false,
      anim: {
        enable: false,
        speed: 1,
        opacity_min: 0.1,
        sync: false,
      },
    },
    links: {
      color: "#3dc6ef",
      enable: true,
    },
    move: {
      enable: true,
      speed: 2,
      direction: "none",
      random: false,
      straight: false,
      out_mode: "out",
      attract: {
        enable: false,
        rotateX: 600,
        rotateY: 1200,
      },

    },
    number: {
      value: 450,
      density: {
        enable: true,
        value_area: 800,
      },
    },
  },
};

</script>
<template>
  <div class="canvas-section">
    <div class="relative" >
      <NuxtParticles id="tsParticles"  :options="option"> </NuxtParticles>
    </div>
  </div>
</template>

<style scoped>
.canvas-section {
  background: linear-gradient(180deg, #D2EEFA 0%, #80D1EF 50%, #00A3DD 100%);
  height: 30vh;
}
#tsParticles {
  position: absolute;
  top: 0px;
  left: 0px;
  height: 200px;
  width: 100%;
  display: block;
}
</style>
