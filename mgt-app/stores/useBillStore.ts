import type { ApiResponse } from "~/types/interfaces";

export const useBillStore = defineStore('billStore', () => {

    const globalStore = useGlobalDataStore()
    const userPayments = ref([])

    const getUserPayments = computed(() => {return userPayments.value})

    async function retrieveUserPayments(){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/user/subscribed-event-bills`);
        const response = data.value as ApiResponse
        if(response.code == 200){
            globalStore.toggleLoadingState('off')
            userPayments.value = response.data
            console.log(userPayments.value)
        }
        return {data, error};
    }
    return {
        retrieveUserPayments,
        getUserPayments,
    }
})