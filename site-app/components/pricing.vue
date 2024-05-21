<script  setup>
const hasPrice = ref(false)
const siteStore = useSiteDataStore()
const feesSetup = ref([
])

async function fetchSiteDate() {
    await siteStore.retrieveSiteDate()
    hasPrice.value = true;
    feesSetup.value = [
    {name: 'Registered ICT professional', fee: siteStore.getSitedData?.defaultFee, iconClass: 'fa-solid fa-user-tie', currency: 'Tsh' },
    {name: 'Non registered ICT professionals and other participants', fee: siteStore.getSitedData?.guestFee, iconClass: 'fa-solid fa-user-tag', currency: 'Tsh' },
    {name: 'Foreign participants', fee: siteStore.getSitedData?.foreignerFee, iconClass: 'fa-solid fa-earth-americas', currency: '$' },
    ]
}
fetchSiteDate()
</script>

<template>
<!-- Start Pricing Section -->
<div class="pricing section">
    <div class="container-fluid">
        <div class="container">
            <div class="section-header">
                <h2>CONFERENCE FEES</h2>
            </div>
            <div class="row">
                <div class="col-lg-4" v-for="item in feesSetup" :key="item.name">
                    <div class="card text-center">
                        <div class="title">
                          <div class="site-icon"><i :class="item.iconClass"></i></div>
                            <h2>{{item.name}}</h2>
                        </div>
                        <div class="price">
                            <UsablesSpinLoader v-if="!hasPrice" />

                            <h4 v-if="hasPrice"><span>{{item.currency}}</span> {{item.fee}}</h4>
                        </div>
                        <div class="option">
                            <ul>
                                <!-- <li><i class="bi bi-check-circle" aria-hidden="true"></i> Unlimited GB Space</li> -->
                                <!-- <li><i class="bi bi-check-circle" aria-hidden="true"></i> 30 Domain Names</li> -->
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Pricing Section -->
</template>

<style scoped></style>
