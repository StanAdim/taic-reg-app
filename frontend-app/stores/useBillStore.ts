import type { ApiResponse } from "~/types/interfaces";

export const useBillStore = defineStore('billStore', () => {

    const globalStore = useGlobalDataStore()
    const userPayments = ref([])
    const allBillGenerated = ref([])
    const settledBills = ref([])
    const gatewayBills = ref([])

    const getUserPayments = computed(() => {return userPayments.value})
    const getAllBills = computed(() => {return allBillGenerated.value})
    const getSettledBills = computed(() => {return settledBills.value})
    const getGatewayBillRequest = computed(() => {return gatewayBills.value})

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
    async function retrieveAllBills(per_page: number = 10, page : number = 1, search: string = ''){
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/event-bills?per_page=${per_page}&page=${page}&search=${search}`);
        const response = data.value as ApiResponse
        if(response.code === 200){
            allBillGenerated.value = response.data
            globalStore.toggleContentLoaderState('off')
        }
        if(response.code === 300){
            allBillGenerated.value = response.data
            globalStore.assignAlertMessage(response?.message, 'warning')
            globalStore.toggleContentLoaderState('off')
        }
        if (error.value){
            console.log(error.value)
            globalStore.toggleContentLoaderState('off')

        }
    }
    async function retrieveAllSettledBills(per_page: number = 10, page : number = 1, search: string = ''){
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/event-bills-settled?per_page=${per_page}&page=${page}&search=${search}`);
        const response = data.value as ApiResponse
        if(response.code === 200){
            settledBills.value = response.data
            globalStore.toggleContentLoaderState('off')
        }
        if(response.code === 300){
            // settledBills.value = response.data
            globalStore.toggleContentLoaderState('off')
            globalStore.assignAlertMessage(response.message, 'success')
        }
        if (error.value){
            console.log(error.value)
            globalStore.toggleContentLoaderState('off')

        }

    }
    // Bill reconciliation
    async function handleBillReconciliation(reconDate){
        globalStore.toggleContentLoaderState('on')

        const {data, error} = await useApiFetch(`/api/bill/reconciliation`,{
            method: 'POST',
            body : reconDate
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
    async function handleBillCancellation(bill_uuid){
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/bill/cancellation/${bill_uuid}`);

        if(data.value){
            console.log(data.value)
            globalStore.assignAlertMessage(data.value?.gepg_message, 'success')
        }
        if(error.value){
            globalStore.assignAlertMessage(error.value.message,'error')
        }
        globalStore.toggleContentLoaderState('off')
    }
    async function handleInvoiceDownload(billDocType = 1,bill_uuid) {
        globalStore.toggleContentLoaderState('on');
        try {
            const { data, error } = await useApiFetch(`/api/generate-invoice/${billDocType}/${bill_uuid}`, {
                method: 'GET',
                responseType: 'blob', // Ensure this is properly set
            });

            if (data.value) {
                // Check if the data is already a blob
                const blob = data.value instanceof Blob ? data.value : new Blob([data.value], { type: 'application/pdf' });
                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `ems_document_${billDocType}_${bill_uuid}_.pdf`);
                document.body.appendChild(link);
                link.click();
                window.URL.revokeObjectURL(url); // Cleanup memory
                globalStore.assignAlertMessage('Downloaded success', 'success');
            }

            if (error.value) {
                globalStore.assignAlertMessage(`Error: ${error.value.message}`, 'error');
                console.error('Error value:', error.value); // Log the error for debugging
            }
        } catch (e) {
            console.error('Exception occurred:', e);
            globalStore.assignAlertMessage('An error occurred while downloading the invoice', 'error');
        } finally {
            globalStore.toggleContentLoaderState('off');
        }
    }


    // Gateway bill requests
    async function retrieveGatewayBillRequests(per_page: number = 10, page : number = 1, search: string = ''){
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/gateway/bills-requests?per_page=${per_page}&page=${page}&search=${search}`);
        const response = data.value as ApiResponse
        if(response.code === 200){
            gatewayBills.value = response.data
            globalStore.toggleContentLoaderState('off')
        }
        if (error.value){
            console.log(error.value)
            globalStore.toggleContentLoaderState('off')

        }
        if(response.code === 300){
            globalStore.toggleContentLoaderState('off')
        }
    }

    return {
        retrieveUserPayments,
        retrieveAllSettledBills,getSettledBills,
        getUserPayments,
        retrieveAllBills,
        handleBillReconciliation,
        handleBillCancellation,
        getAllBills,
        handleInvoiceDownload,
        retrieveGatewayBillRequests,getGatewayBillRequest
    }
})