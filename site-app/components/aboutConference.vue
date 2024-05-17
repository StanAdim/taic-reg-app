<script setup>
// const siteStore = useSiteDataStore()

// async function retriveSitedata() {
//     await siteStore.retriveSiteData()
// }
// retriveSitedata()
const getSitedData = ref({
    aboutConference: `The Tanzania Annual ICT Conference (TAIC) is the biggest ICT sector event in Tanzania organised annually by the ICT Commission (ICTC). 
    As for the last seven conferences, TAIC brings together stakeholders including academia, researchers, development partners,
     business industry, investors and youth in digital innovation spaces and practitioners in the ICT Industry.
      The conference aims to call the attention of all stakeholders through discussion and knowledge sharing on matters 
      related to policy, research, innovation and business aspects of the digital economy and ICT sector contribution to Tanzania’s 
      economic growth and global digital presence. The 07th Tanzania Annual ICT Conference 2024 (TAIC 2024) 
      will be held at the Julius Nyerere International Conference Centre (JNICC). TAIC 2024 will have pre-conference events 
      of Women and Youth in ICT open to the public and will be held on 13th and 17th October 2024 respectively. 
      The main TAIC 2024 will be held from 18th to 20th October 2024.`
})
</script>
<template>
<section>
    <div class="container" id="featured">
        <div class="section-header" data-aos="fade-up" data-aos-delay="100">
            <h2>ABOUT CONFERENCE</h2>
        </div>
        <p>{{getSitedData?.aboutConference }}</p>
    </div>
</section>
</template>