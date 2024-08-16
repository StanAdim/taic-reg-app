<script  setup>
const hasPrice = ref(true)
const global = useGlobalDataStore()
// const siteStore = useSiteDataStore()
const feesSetup = ref([
])
const getSitedData = ref({
    defaultFee: "420,000",
    guestFee: '500,000',
    foreignerFee: 300
})
async function retriveSitedata() {
    // const {data, error}  = await siteStore.retriveSiteData()
    // hasPrice.value = false;
    feesSetup.value = [
    {name: 'Registered ICT professional', fee: getSitedData.value?.defaultFee, iconClass: 'fa-solid fa-user-tie', currency: 'Tsh' },
    {name: 'Non registered ICT professionals and other participants', fee: getSitedData.value?.guestFee, iconClass: 'fa-solid fa-user-tag', currency: 'Tsh' },
    {name: 'Foreign participants', fee: getSitedData.value?.foreignerFee, iconClass: 'fa-solid fa-earth-americas', currency: '$' },
    ]
}
retriveSitedata()
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
