<script setup>

</script>
<template>
  <div class="mb-2 rounded-md">
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
  width: 24px;
  height: 24px;
  animation: spin .8s linear infinite;
}.loader2 {
  border: 6px solid rgba(17, 43, 131, 0.56);
  border-left-color: #51f1ea;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  animation: spin 1s linear infinite;
}


@keyframes spin {
  to {
    transform: rotate(-360deg);
  }
}
</style>
