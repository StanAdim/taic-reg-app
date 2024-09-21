
export const useSupportActionStore = defineStore('supportStore', () => {

    const globalStore = useGlobalDataStore()
    //Stores
    const userSupportRequests= ref <[]>([]);
    const allSupportRequests= ref <[]>([]);
    const singleSupportRequest= ref (null);
    const modalStatus= ref<boolean>(false)

    //Computed
    const getUserSupportRequests = computed(() => {return userSupportRequests.value})
    const getAllSupportRequest = computed(() => {return allSupportRequests.value})
    const getSingleSupportRequest = computed(() => {return singleSupportRequest.value})
    const getModalStatus : boolean = computed(() => { return modalStatus.value})

    //Actions
    const toggleModalStatus = (state) =>  modalStatus.value = state;
    const createNewRequest = async (passedData)=> {
        const { data, error } = await useApiFetch(`/api/request-support`, {
            method: 'POST',
            body: passedData,
        });
        if(data.value){
            const message = 'New request initiated!';
            await  retrieveUserSupportRequests()
            toggleModalStatus(false)
            globalStore.toggleBtnLoadingState(false);
            globalStore.assignAlertMessage(message, 'success');
        }else {
            console.log(error.value.data.message)
            globalStore.toggleBtnLoadingState(false);
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
        }
    }
    const triggerSingleRequest = async (requestId)=> {
        const { data, error } = await useApiFetch(`/api/request-support/${requestId}`);
        if(data.value){
            singleSupportRequest.value = data.value?.data;
        }else {
            console.log(error.value.data.message)
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
        }
    }
    const retrieveLatestSingleRequest = async ()=> {
        const { data, error } = await useApiFetch(`/api/request-support-latest`);
        if(data.value){
            const message = '!';
            singleSupportRequest.value = data.value?.data;
            // globalStore.assignAlertMessage(message, 'success');
        }else {
            console.log(error.value.data.message)
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
        }
    }
    const updateRequestStatus = async (requestId)=> {
        const { data, error } = await useApiFetch(`/api/request-support/${requestId}`);
        if(data.value){
            const message = 'Request status changed!';
            await  retrieveAllInvitationRequests()
            globalStore.toggleBtnLoadingState(false);
            globalStore.assignAlertMessage(message, 'success');
        }else {
            console.log(error.value.data.message)
            globalStore.toggleBtnLoadingState(false);
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
        }
    }
    async function retrieveUserSupportRequests() {
        globalStore.toggleContentLoaderState('on')
        const { data, error } = await useApiFetch(`/api/request-support`);
        if(data.value){
            userSupportRequests.value = data.value?.data;
            globalStore.toggleContentLoaderState('off');
        }
        else {
            globalStore.toggleContentLoaderState('off');
            globalStore.assignAlertMessage(error.value?.message, 'error')
        }
    }
    async function retrieveResponseRequests() {
        globalStore.toggleContentLoaderState('on')
        const { data, error } = await useApiFetch(`/api/respond-support-request`);
        if(data.value){
            // allInvitations.value = data.value;
            globalStore.toggleContentLoaderState('off');
        }
        else {
            globalStore.toggleContentLoaderState('off');
            globalStore.assignAlertMessage(error.value?.message, 'error')
        }
    }

    // Responses
    const createResponseToRequest = async (passedData)=> {
        globalStore.toggleLoadingState('on');
        const { data, error } = await useApiFetch(`/api/respond-support-request`, {
            method: 'POST',
            body: passedData,
        });
        if(data.value){
            const message = 'New response initiated!';
            await  retrieveUserSupportRequests()
            toggleModalStatus(false)
            globalStore.toggleBtnLoadingState(false);
            globalStore.toggleLoadingState('off');
            globalStore.assignAlertMessage(message, 'success');
        }else {
            console.log(error.value.data.message)
            globalStore.toggleLoadingState('off');
            globalStore.toggleBtnLoadingState(false);
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
        }
    }

    return {
        getUserSupportRequests,getModalStatus,
        getAllSupportRequest,
        toggleModalStatus,getSingleSupportRequest,
        updateRequestStatus,
        createNewRequest,createResponseToRequest,
        retrieveResponseRequests,
        retrieveLatestSingleRequest,
        triggerSingleRequest,
        retrieveUserSupportRequests,
    }
})