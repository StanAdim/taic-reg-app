import type { ApiResponse } from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

export const useBoothStore = defineStore('boothStore', () => {
    const globalStore = useGlobalDataStore()

    //Stores
    const createUpdateBoothDialogStatus= ref(false);
    const booths= ref([]);

    //Computed
    const getCreateUpdateBoothState = computed(() => {return createUpdateBoothDialogStatus.value})
    const getBooths = computed(() => {return booths.value})

    //Actions
    const toggleCreateUpdateDialogState = (state:boolean)=> (createUpdateBoothDialogStatus.value = state)

// Function to fetch details of a single exhibition booth
    async function retrieveBooths() {
        globalStore.toggleLoadingState('on');
        const { data, error } = await useApiFetch(`/api/exhibition-booth`);
            if(data.value){
                booths.value = data.value?.data;
            globalStore.toggleLoadingState('off');
            }
            else {
                globalStore.toggleLoadingState('off');
                globalStore.assignAlertMessage(error.value?.data?.message, 'error')
            }
    }
    // Function to fetch details of a single exhibition booth
    async function fetchSingleBooth(boothId: string) {
        globalStore.toggleLoadingState('on');
        const { data, error } = await useApiFetch(`/api/exhibition-booth/${boothId}`);
        const dataResponse = data.value as ApiResponse;
        if (dataResponse?.code === 200) {
            singleBoothDetail.value = dataResponse.data;
        }
        globalStore.toggleLoadingState('off');
        return { data, error };
    }

// Function to create a new exhibition booth
    async function createBooth(boothData: BoothData) {
        globalStore.toggleLoadingState('on');
        const { data, error } = await useApiFetch('/api/exhibition-booth', {
            method: 'POST',
            body: boothData
        });
        const dataResponse = data.value as ApiResponse;
        if (dataResponse?.code === 201) {
            console.log('Booth created successfully:', dataResponse.data);
        }
        globalStore.toggleLoadingState('off');
        return { data, error };
    }

// Function to update an existing exhibition booth
    async function updateBooth(boothId: string, updatedBoothData: BoothData) {
        globalStore.toggleLoadingState('on');
        const { data, error } = await useApiFetch(`/api/exhibition-booth/${boothId}`, {
            method: 'PUT',
            body: updatedBoothData
        });
        const dataResponse = data.value as ApiResponse;
        if (dataResponse?.code === 200) {
            console.log('Booth updated successfully:', dataResponse.data);
        }
        globalStore.toggleLoadingState('off');
        return { data, error };
    }

// Function to delete an existing exhibition booth
    async function deleteBooth(boothId: string) {
        globalStore.toggleLoadingState('on');
        const { data, error } = await useApiFetch(`/api/exhibition-booth/${boothId}`, {
            method: 'DELETE'
        });
        const dataResponse = data.value as ApiResponse;
        if (dataResponse?.code === 200) {
            console.log('Booth deleted successfully');
        }
        globalStore.toggleLoadingState('off');
        return { data, error };
    }


    return {
        getCreateUpdateBoothState,
        retrieveBooths,
        toggleCreateUpdateDialogState,
        createBooth,
        updateBooth,
        getBooths,
        deleteBooth,
        fetchSingleBooth,
    }
})