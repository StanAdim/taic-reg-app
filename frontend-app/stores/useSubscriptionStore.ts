import type { ApiResponse } from "~/types/interfaces";

export const useSubscriptionStore = defineStore('subscriptionStore', () => {

    const eventDialogStatus = ref(false);
    const globalStore = useGlobalDataStore()
    const subscribedEvents = ref([])

    const getSubscribedEvents = computed(() => {return subscribedEvents.value})

    async function subscribeToAnEvent(subscription: string){
        globalStore.toggleLoadingState('on')
        const {data, error} = await useApiFetch(`/api/subscribe-event/${subscription.eventId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
            globalStore.assignAlertMessage(dataResponse?.message, 'success')
            eventDialogStatus.value = false;
            globalStore.toggleLoadingState('off')
            globalStore.toggleBtnLoadingState(false)

            globalStore.toggleDoneCheckVisibility()
        }
        if(dataResponse?.code === 300){
            globalStore.assignAlertMessage(dataResponse?.message, 'danger')
            eventDialogStatus.value = false;
            globalStore.toggleLoadingState('off')
            globalStore.toggleBtnLoadingState(false)
            globalStore.toggleDoneCheckVisibility()
        }
        if(error.value){
            globalStore.assignAlertMessage(error.value?.data?.message, 'warning')
            eventDialogStatus.value = false;
            globalStore.toggleLoadingState('off')
            globalStore.toggleBtnLoadingState(false)
            // globalStore.toggleDoneCheckVisibility()
        }
        return {data, error};
    }
    async function retrieveSubscribedEvents(): Promise<ApiResponse>{
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/user/subscribed-events`);
        const response = data.value as ApiResponse
        if(response.code == 200){
            globalStore.toggleContentLoaderState('off')
            subscribedEvents.value = response.data
        }
        globalStore.toggleContentLoaderState('off')
        return {data, error};
    }
    async function unsubscribedUserEvent(subscription){
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/unsubscribe-user-from-event`,{
            method: 'POST',
            body : subscription
        });
        if(data.value){
            console.log(data.value)
            globalStore.assignAlertMessage(data.value?.message, 'success')

        }
        if(error.value){
            console.log(error.value)
            globalStore.assignAlertMessage(error.value.data?.message,'error')
        }
        globalStore.toggleContentLoaderState('off')
    }
    return {
        eventDialogStatus,
        subscribeToAnEvent,
        getSubscribedEvents,
        retrieveSubscribedEvents,
        unsubscribedUserEvent
    }
})