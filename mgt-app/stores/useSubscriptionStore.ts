import type { ApiResponse } from "~/types/interfaces";

export const useSubscriptionStore = defineStore('subscriptionStore', () => {

    const eventDialogStatus = ref(false);
    const globalStore = useGlobalDataStore()

    const getEvents = computed(() => {return events.value})

    async function subscribeToAnEvent(subscription: string){
        globalStore.toggleLoadingState('on')
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/subscribe-event/${subscription.eventId}/${subscription.eventFee}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
            globalStore.assignAlertMessage(dataResponse?.message, 'success')
            eventDialogStatus.value = false;
            globalStore.toggleLoadingState('off')
            globalStore.toggleDoneCheckVisibility()
        }
        if(dataResponse?.code === 300){
            globalStore.assignAlertMessage([dataResponse?.message], 'danger')
            eventDialogStatus.value = false;
            globalStore.toggleLoadingState('off')
            globalStore.toggleDoneCheckVisibility()
        }
        return {data, error};
    }
    return {
        eventDialogStatus,
        subscribeToAnEvent,
    }
})