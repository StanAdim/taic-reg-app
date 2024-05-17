<template>
    <div class=" bg-sky-100 p-1 mb-4 container">
        <div class="row justify-content-center align-content-center">
          <div class="loader1 m-1"></div>
          <!-- <div class="loader m-1"></div> -->
          <div class="loader2 m-1"></div>
        </div>
    </div>
    </template>
    
    <script setup>
  
    </script>
    
    <style scoped>
    .loader1 {
      border: 6px solid #d861078f;
      border-left-color: #10cdc4;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin .8s linear infinite;
    }
    .loader2 {
      border: 6px solid #d861078f;
      border-left-color: #10cdc4;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin .5s linear infinite;
    }
    
    @keyframes spin {
      to {
        transform: rotate(-360deg);
      }
    }
    </style>
    