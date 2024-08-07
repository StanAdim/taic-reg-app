import type { ApiResponse } from "~/types/interfaces";

export const useBillStore = defineStore('billStore', () => {

    const globalStore = useGlobalDataStore()
    const userPayments = ref([])
    const allBillGenerated = ref([])

    const getUserPayments = computed(() => {return userPayments.value})
    const getAllBills = computed(() => {return allBillGenerated.value})

    async function retrieveUserPayments(){
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/user/subscribed-event-bills`);
        const response = data.value as ApiResponse
        if(response.code == 200){
            globalStore.toggleLoadingState('off')
            globalStore.toggleContentLoaderState('off')
            userPayments.value = response.data
        }
        return {data, error};
    }
    async function retrieveAllBills(){
        const {data, error} = await useApiFetch(`/api/event-bills`);
        const response = data.value as ApiResponse
        if(response.code == 200){
            globalStore.toggleLoadingState('off')
            allBillGenerated.value = response.data
        }
        return {data, error};
    }
    async function handleBillReconciliation(bill_uuid){
        const {data, error} = await useApiFetch(`/api/bill/reconciliation/${bill_uuid}`);
        if(data.value){
            console.log(data.value)
        }
        if(error.value){
            globalStore.assignAlertMessage(error.value.message,'error')
        }
        globalStore.toggleLoadingState('off')
    }
    async function handleBillCancellation(bill_uuid){
        const {data, error} = await useApiFetch(`/api/bill/cancellation/${bill_uuid}`);
        if(data.value){
            console.log(data.value)
        }
        if(error.value){
            globalStore.assignAlertMessage(error.value.message,'error')
        }
        globalStore.toggleLoadingState('off')
    }
    return {
        retrieveUserPayments,
        getUserPayments,
        retrieveAllBills,
        handleBillReconciliation,
        handleBillCancellation,
        getAllBills
    }
})