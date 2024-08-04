import type { ApiResponse } from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

export const useRequestBoothStore = defineStore('requestBoothStore', () => {
    const globalStore = useGlobalDataStore()

    //Stores
    const requestBoothDialog= ref(false);
    const boothRequests= ref([]);

    //Computed
    const getRequestBoothDialogState = computed(() => {return requestBoothDialog.value})
    const getBoothRequests = computed(() => {return boothRequests.value})

    //Actions
    const toggleRequestBoothDialogState = (state:boolean)=> (requestBoothDialog.value = state)

// Function to create a new exhibition booth
    async function createBoothReq(boothRequestsData: BoothData) {
        globalStore.toggleLoadingState('on');
        const { data, error } = await useApiFetch('/api/booth-request', {
            method: 'POST',
            body: boothRequestsData
        });
        if (data.value?.code === 200) {
            globalStore.assignAlertMessage(data.value?.message, 'success')
            globalStore.toggleLoadingState('off');
            toggleRequestBoothDialogState(false)

        }
        else{
        globalStore.toggleLoadingState('off');
            globalStore.assignAlertMessage(error.value?.data.message, 'error')
            toggleRequestBoothDialogState(false)
        }
    }

    async function retrieveUserBoothsRequests() {
        globalStore.toggleLoadingState('on');
        const { data, error } = await useApiFetch(`/api/booth-request`);
        if(data.value){
            boothRequests.value = data.value?.data;
            globalStore.toggleLoadingState('off');
        }
        else {
            globalStore.toggleLoadingState('off');
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
        }
    }



    return {
        getRequestBoothDialogState,getBoothRequests,
        toggleRequestBoothDialogState,
        createBoothReq,
        retrieveUserBoothsRequests,
    }
})