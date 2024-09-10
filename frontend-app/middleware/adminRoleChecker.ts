
export default defineNuxtRouteMiddleware((to, from) => {
    const auth = useAuthStore();
    const globalStore = useGlobalDataStore();
    if (auth.getUserRole !== 'admin') {
        globalStore.assignAlertMessage('Not Allowed resource', 'warning')
        return navigateTo("/crm/", {replace: true});
    }
})