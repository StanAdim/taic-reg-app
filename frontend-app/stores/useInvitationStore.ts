
export const useInvitationStore = defineStore('invitationStore', () => {

    const globalStore = useGlobalDataStore()
    //Stores
    const allInvitations= ref <[]>([]);
    const invitationRequest= ref <[]>([]);
    const invitationModalStatus= ref(false)
    const dataUpdate : object= ref(null)

    //Computed
    const getInvitationRequests = computed(() => {return allInvitations.value})
    const getSingleInvitation = computed(() => {return invitationRequest.value})
    const getDataToBeUpdated = computed(() => {return dataUpdate.value})
    const getInvitationModalStatus = computed(() => {return invitationModalStatus.value})

    //Actions
    const assignDataToBeUpdated = (dataObject) =>  dataUpdate.value = dataObject;
    const toggleNewInvitationModalStatus = (state) =>  invitationModalStatus.value = state;
    const createInvitationRequest = async (passedData)=> {
        const { data, error } = await useApiFetch(`/api/request-invitation-letter`, {
            method: 'POST',
            body: passedData,
        });
        if(data.value){
            const message = 'New request initiated!';
            await  retrieveAllInvitationRequests()
            toggleNewInvitationModalStatus(false)
            globalStore.assignAlertMessage(message, 'success');
            globalStore.toggleBtnLoadingState(false);
        }else {
            console.log(error.value.data.message)
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
            globalStore.toggleBtnLoadingState(false);
        }
    }
    const updateInvitationRequest = async (passedData: object , invitationRequest_id: string)=> {
        const { data, error } = await useApiFetch(`/api/request-invitation-letter/${invitationRequest_id}`, {
            method: 'PUT',
            body: passedData,
        });
        if(data.value){
            const message = 'An Invitation request is updated!';
            await  retrieveAllInvitationRequests()
            toggleNewInvitationModalStatus(false)
            globalStore.assignAlertMessage(message, 'success');
            globalStore.toggleBtnLoadingState(false);
        }else {
            console.log(error.value.data.message)
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
            globalStore.toggleBtnLoadingState(false);
        }
    }
    const updateRequestStatus = async (requestId)=> {
        const { data, error } = await useApiFetch(`/api/request-invitation-letter/${requestId}`);
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
    async function retrieveAllInvitationRequests() {
        globalStore.toggleContentLoaderState('on')
        const { data, error } = await useApiFetch(`/api/request-invitation-letter`);
        if(data.value){
            allInvitations.value = data.value;
            globalStore.toggleContentLoaderState('off');
        }
        else {
            globalStore.toggleContentLoaderState('off');
            globalStore.assignAlertMessage(error.value?.message, 'error')
        }
    }

    return {
        getInvitationRequests,getSingleInvitation,
        toggleNewInvitationModalStatus,
        updateRequestStatus,
        createInvitationRequest,retrieveAllInvitationRequests,
        getInvitationModalStatus, updateInvitationRequest,
        getDataToBeUpdated, assignDataToBeUpdated ,
    }
})