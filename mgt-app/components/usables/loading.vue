<script setup>

</script>
<template>
  <div class=" bg-sky-100 mb-4 ">
    <div class="flex  justify-center align-center">
      <div class="loader1 m-1"></div>
<!--       <div class="loader m-1"></div> -->
      <div class="loader2 m-1"></div>
    </div>
  </div>
</template>
<style scoped>
.loader1 {
  border: 6px solid rgba(3, 58, 175, 0.56);
  border-left-color: #51f1ea;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  animation: spin .8s linear infinite;
}.loader2 {
  border: 6px solid rgba(17, 43, 131, 0.56);
  border-left-color: #51f1ea;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  animation: spin 1s linear infinite;
}


@keyframes spin {
  to {
    transform: rotate(-360deg);
  }
}
</style>
