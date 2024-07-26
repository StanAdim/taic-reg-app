import {useAuthStore} from "~/stores/useAuthStore";

export default defineNuxtRouteMiddleware((to, from) => {
    const auth = useAuthStore();
    const globalStore = useGlobalDataStore();

    if (!auth.isLoggedIn) {
        globalStore.assignAlertMessage('Login to continue', 'warning')
        return navigateTo("/", {replace: true});
    }
})