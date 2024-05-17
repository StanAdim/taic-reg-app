<script lang="ts" setup>
const config = useRuntimeConfig()
const year = new Date();
</script>

<template>
<!--  Footer  -->
<footer id="footer" class="footer-section">
    <div class="container">
        <div class="footer-content  pb-5">
            <div class="row">
                <div class="col-xl-4 col-lg-4 mb-50">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <nuxt-link to="/" class="logo d-flex align-items-center">
                                <img src="assets/images/logos/logo-min.png" alt="logo">
                             </nuxt-link>
                        </div>
                        <div class="footer-text">
                            <p>The Information and Communication Technologies Commission (ICTC) 
                                was established by the Presidential Decree Government Notice 
                                (GN) No.532 published in the Government Gazette No. 4 Vol. 96 
                                dated 20 November 2015.</p>
                        </div>
                        <div class="footer-social-icon">
                            <span>Follow us</span>
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 col-sm-12 footer-column">
                    <div class="service-widget footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Services</h3>
                        </div>
                        <ul class="list">
                            <li><a href="https://ictc.go.tz">ICT Commission</a></li>
                            <li><a href="https://mawasiliano.go.tz">Mawasiliano</a></li>
                            <li><a href="https://iprs.ictc.go.tz">ICT Professional Registration</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 col-sm-12 footer-column">
                    <div class="service-widget footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Information</h3>
                        </div>
                        <ul class="list">
                            <li><nuxt-link href="/">Home</nuxt-link></li>
                            <li><a href="/#price">Conference Fees</a></li>
                            <li><nuxt-link href="/#team">Speakers</nuxt-link></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-6 mb-50">
                    <div class="contact-widget footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Contacts</h3>
                        </div>
                        <div class="footer-text">
                            <p><i class="bi bi-geo-alt-fill mr-15"></i>14 Jamhuri Street, Dar es salaam </p>
                            <p><i class="bi bi-telephone-inbound-fill mr-15"></i> +2557 38 171 742</p>
                            <p><i class="bi bi-envelope-fill mr-15"></i> dg@ictc.go.tz</p>
                            <p><i class="bi bi-envelope-fill mr-15"></i> info@ictc.go.tz</p>
                        </div>
                    </div>
                    <div class="footer-widget">
                        <div class="footer-widget-heading">
                            <h3>Newsletter</h3>
                        </div>
                        <div class="footer-text mb-25">
                            <p>Don't miss to subscribe to our new feeds, kindly fill the form below.</p>
                        </div>
                        <div class="subscribe-form">
                            <form action="#">
                                <input type="text" placeholder="Email Address">
                                <button><i class="bi bi-telegram"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 col-lg-6 text-left text-lg-left">
                    <div class="copyright-text">
                        <p>{{ config.public.appName }} © {{year.getFullYear()}} - Designed by <nuxt-link to="/auth/login">ICT Commission Team</nuxt-link></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->
</template>

<style scoped></style>
