<script setup>
function showTab(tabId) {
    // Hide all tab content
    // const tabContents = document.querySelectorAll('.tab-content');
    // tabContents.forEach((content) => {
    //   content.classList.add('hidden');
    // });

    // // Show the selected tab content
    // const selectedTab = document.getElementById(tabId);
    // if (selectedTab) {
    //   selectedTab.classList.remove('hidden');
    // }

    // // Remove the 'active' class from all tab buttons
    // const tabButtons = document.querySelectorAll('.tab-button');
    // tabButtons.forEach((button) => {
    //   button.classList.remove('active');
    // });

    // // Add the 'active' class to the clicked tab button
    // const clickedButton = document.querySelector(`[onclick="showTab('${tabId}')"]`);
    // if (clickedButton) {
    //   clickedButton.classList.add('active');
    // }
  }
  // Initialize the first tab
  showTab('tab1');
</script>
<template>
<div class=" w-screen my-2 mx-auto">
  <!-- Tab Buttons -->
  <div class="bg-blue-600 p-2 rounded-t-lg">
    <div class="flex justify-center space-x-4">
      <button class="px-4 py-2 text-white font-semibold rounded-lg border-b-4 border-blue-700 hover:bg-blue-700 focus:outline-none tab-button" @click="showTab('tab1')">Tab 1</button>
      <button class="px-4 py-2 text-white font-semibold rounded-lg border-b-4 border-blue-700 hover:bg-blue-700 focus:outline-none tab-button" @click="showTab('tab2')">Tab 2</button>
      <button class="px-4 py-2 text-white font-semibold rounded-lg border-b-4 border-blue-700 hover:bg-blue-700 focus:outline-none tab-button" @click="showTab('tab3')">Tab 3</button>
    </div>
  </div>

  <!-- Tab Content -->
  <div id="tab1" class="p-4 tab-content bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-semibold mb-2 text-blue-700">Tab 1 Content</h2>
    <p>
      Vestibulum condimentum imperdiet velit nec ornare. Nullam lobortis urna posuere quam porta consequat. Donec
      commodo diam lectus, sit amet tempor dolor scelerisque eget. Vestibulum at lectus dui. Maecenas consectetur tempor
      ipsum non porttitor. Cras accumsan mattis aliquam. Fusce eleifend maximus elit facilisis condimentum. Mauris non
      risus sed ligula convallis fermentum.
      <br>
      Quisque eu purus nunc. Ut eget ligula ac lorem laoreet scelerisque in ut
      nulla. Quisque volutpat elit eget tellus pharetra, vel sollicitudin velit scelerisque. Vivamus ac libero eu nunc
      congue malesuada eu vitae est.
    </p>
  </div>
  <div id="tab2" class="p-4 tab-content bg-white shadow-md rounded-lg hidden">
    <h2 class="text-2xl font-semibold mb-2 text-blue-700">Tab 2 Content</h2>
    <p>Phasellus eget euismod libero, nec ullamcorper justo. Phasellus eget euismod libero, nec ullamcorper justo.
      Phasellus eget euismod libero, nec ullamcorper justo. Etiam eget augue in ante gravida facilisis.</p>
  </div>
  <div id="tab3" class="p-4 tab-content bg-white shadow-md rounded-lg hidden">
    <h2 class="text-2xl font-semibold mb-2 text-blue-700">Tab 3 Content</h2>
    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. Sed ut
      perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium. Sed ut perspiciatis
      unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
  </div>

</div>
</template>

<style>
  .tab-button.active {
    background-color: #0e9bd8;
    border-color: #ebeef1;
    color: #1d5d92;
  }
</style>