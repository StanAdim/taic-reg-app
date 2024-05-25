import type { ApiResponse } from "~/types/interfaces";

export const useSubscriptionStore = defineStore('subscriptionStore', () => {

    const eventDialogStatus = ref(false);
    const globalStore = useGlobalDataStore()

    const getEvents = computed(() => {return events.value})

    async function subscribeToAnEvent(passId: string){
        globalStore.toggleLoadingState('on')
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/subscribe-event/${passId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
            globalStore.assignAlertMessage(dataResponse?.message, 'success')
            eventDialogStatus.value = false;
            globalStore.toggleLoadingState('off')
            globalStore.toggleConfirmToAttendModalStatus()
        }
        return {data, error};
    }
    return {
        eventDialogStatus,
        subscribeToAnEvent,
    }
})