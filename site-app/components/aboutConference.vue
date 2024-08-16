<script setup>
// const siteStore = useSiteDataStore()

// async function retriveSitedata() {
//     await siteStore.retriveSiteData()
// }
// retriveSitedata()
const getSitedData = ref({
    aboutConference1: `The 8th Tanzania Annual ICT Conference 2024 (TAIC-2024), first Africa Edition, organized by the
     ICT Commission (ICTC), in collaboration with ELEVATE and the African Union Development
     Agency-NEPAD (AUDA-NEPAD), is scheduled to take place in Dar es Salaam, Tanzania at the Julius Nyerere International
     Conference Centre (JNICC) from October 13th to October 17th, 2024. Pre-conference events, including the African AI Competition,
     are planned for October 13th and 14th, and will be open to public participation.`,
  aboutConference2: `Building on the success of previous conferences, TAIC-2024 will gather a broad spectrum of participants,
  including ICT professionals, practitioners, academics, researchers, development partners, industry leaders, and innovators in digital technology.
  This year’s theme, “Unleashing the Power of Artificial Intelligence and Robotics for Socio-economic Transformation”, focuses on the transformative
  impact of these technologies across various sectors.`,
  aboutConference3: `At a pivotal time when the global economy is embracing digital transformation,
  Tanzania is strategically advanc- ing its economic policies to exploit the full potential of AI and robotics.
  This effort is aimed at transitioning into a higher middle-income economy.
  TAIC-2024 will provide an invaluable platform for sharing innovative ideas, practices, and research findings among ICT profession- als,
  academia, government and private institutions, and development partners. This gathering is essential for steering Tanzania
  towards a digitally empowered economy, characterized by enhanced ICT accessibility, affordability, and availability.`,

})
</script>
<template>
<section>
    <div class="container" id="featured">
        <div class="section-header" data-aos="fade-up" data-aos-delay="100">
            <h2>ABOUT CONFERENCE</h2>
        </div>
        <p>{{getSitedData?.aboutConference1 }}</p>
        <p>{{getSitedData?.aboutConference2 }}</p>
        <p>{{getSitedData?.aboutConference3 }}</p>

    </div>
</section>
</template>