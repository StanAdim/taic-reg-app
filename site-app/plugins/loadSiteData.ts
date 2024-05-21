export default defineNuxtPlugin(async (nuxtApp) => {
    const siteDataStore = useSiteDataStore()
    if (!siteDataStore.getSitedData) {
        await siteDataStore.retrieveSiteDate()
    }
})