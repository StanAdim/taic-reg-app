
export const useInvitationStore = defineStore('invitationStore', () => {

    const globalStore = useGlobalDataStore()
    //Stores
    const allInvitations= ref <[]>([]);
    const invitationRequest= ref <[]>([]);
    const invitationModalStatus= ref(false)

    //Computed
    const getInvitationRequests = computed(() => {return allInvitations.value})
    const getSingleInvitation = computed(() => {return invitationRequest.value})
    const getInvitationModalStatus = computed(() => {return invitationModalStatus.value})

    //Actions
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
        }else {
            console.log(error.value.data.message)
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
        }
    }
    const updateRequestStatus = async (requestId)=> {
        const { data, error } = await useApiFetch(`/api/request-invitation-letter/${requestId}`);
        if(data.value){
            const message = 'Request status changed!';
            await  retrieveAllInvitationRequests()
            globalStore.assignAlertMessage(message, 'success');
        }else {
            console.log(error.value.data.message)
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
        getInvitationModalStatus
    }
})