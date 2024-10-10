<script lang="ts" setup>
const config = useRuntimeConfig()
</script>

<template>
    <header id="header" class="header d-flex align-items-center sticked stikcy-menu">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
            <nuxt-link to="/" class="logo d-flex align-items-center">
              <span>8 <sup>th</sup> TAIC </span>
                <!-- <img src="assets/images/logo.png" alt="logo"> -->
            </nuxt-link>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><nuxt-link to="/" class="">Home</nuxt-link></li>
<!--                    <li><nuxt-link to="/" class="">About</nuxt-link></li>-->
<!--                    <li class="dropdown"><a href="#"><span>Sponsorship</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>-->
<!--                        <ul>-->
<!--                            <li><nuxt-link to="/">Local Sponsorships</nuxt-link></li>-->
<!--                            <li><nuxt-link to="/">International Sponsorship</nuxt-link></li>-->
<!--                        </ul>-->
<!--                    </li>-->
                    <li><nuxt-link to="/#exhibitors" class="">Exhibitors</nuxt-link></li>
                    <li><nuxt-link to="/#sponsors" class="">Sponsors</nuxt-link></li>
<!--                    <li><nuxt-link to="/" class="">Hospitality</nuxt-link></li>-->
                    <li><a target="_blank" href="https://www.tanzaniatourism.go.tz/">Tours</a></li>
                    <li><a target="_blank" href="https://ems.ictc.go.tz/conference-timetable">Conference Timetable</a></li>
                </ul>
            </nav>
            <!-- .navbar -->
            <!-- <nuxt-link to="" class="btn-get-started hide-on-mobile">Register Now</nuxt-link> -->
            <button id="darkmode-button"><i class="bi bi-moon-fill"></i></button>
            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
        </div>
    </header>
</template>

<style scoped></style>
