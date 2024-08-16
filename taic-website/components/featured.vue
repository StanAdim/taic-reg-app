<script setup>
const hasAgenda = ref(false)
</script>
<template>
<section>
    <div class="container" id="featured">
        <div class="section-header" data-aos="fade-up" data-aos-delay="100">
            <h2>CONFERENCE AGENDA</h2>
        </div>
        <p class="text-center">Issues that will be under discussions and presentations</p>
        <UsablesSpinLoader />
        <div class="row" v-if="hasAgenda">
            <!-- start  left -->
            <div class="col-md-4 left">
                <div class="list-wrap" data-aos="fade-up" data-aos-delay="100">
                    <div class="description">
                        <h4>Experience</h4>
                        <p>Ronsectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="icon">
                        <img src="assets/images/icons/icon-1.svg" alt="icon">
                    </div>
                </div>

                <div class="list-wrap" data-aos="fade-up" data-aos-delay="400">
                    <div class="description">
                        <h4>Products</h4>
                        <p>Ronsectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="icon">
                        <img src="assets/images/icons/icon-2.svg" alt="icon">
                    </div>
                </div>


                <div class="list-wrap" data-aos="fade-up" data-aos-delay="500">
                    <div class="description">
                        <h4>Approach</h4>
                        <p>Ronsectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                    <div class="icon">
                        <img src="assets/images/icons/icon-3.svg" alt="icon">
                    </div>
                </div>
            </div>
            <!-- end  left -->

            <!-- start  center -->
            <div class="col-md-4 p-4 p-sm-5 center">
                <div class="list-center-wrap" data-aos="fade-up" data-aos-delay="100">
                    <div class="center-icon">
                        <img src="assets/images/features.jpg" alt="icon">
                    </div>
                </div>
            </div>
            <!-- end  center -->
            <!-- start  right -->
            <div class="col-md-4 right">
                <div class="list-wrap" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon">
                        <img src="assets/images/icons/icon-4.svg" alt="icon">
                    </div>
                    <div class="description">
                        <h4>Pricing</h4>
                        <p>Ronsectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>

                <div class="list-wrap" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon">
                        <img src="assets/images/icons/icon-5.svg" alt="icon">
                    </div>
                    <div class="description">
                        <h4>Delivery</h4>
                        <p>Ronsectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>


                <div class="list-wrap" data-aos="fade-up" data-aos-delay="500">
                    <div class="icon">
                        <img src="assets/images/icons/icon-6.svg" alt="icon">
                    </div>
                    <div class="description">
                        <h4>Support</h4>
                        <p>Ronsectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
            </div>
            <!-- end  right -->
        </div>

    </div>
</section>
</template>