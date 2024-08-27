import type {ApiResponse, DocumentMaterial} from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

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
        try {
            for (let [key, value] of passedData.entries()) {
                console.log(`${key}:`, value);
            }
            const { data, error } = await useApiFetch('/anchor/download', {
                method: 'POST',
                body: passedData,
            });
            if(data.value){
                const message = 'Document uploaded successfully!';
                await  retrieveAllInvitationRequests()
                toggleDocumentUploadModalStatus(false)
                globalStore.assignAlertMessage(message, 'success');
            }
            if(error.value){
                globalStore.assignAlertMessage(error.value?.message, 'error');
            }
        } catch (err) {
            console.log(error)
            const message = 'Failed to upload document.';
            globalStore.assignAlertMessage(message, 'error');
        }
    }
    async function retrieveAllInvitationRequests() {
        globalStore.toggleContentLoaderState('on')
        const { data, error } = await useApiFetch(`/api/events-documents`);
        if(data.value){
            allInvitations.value = data.value?.data;
            globalStore.toggleContentLoaderState('off');
        }
        else {
            globalStore.toggleContentLoaderState('off');
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
        }
    }

    return {
        getInvitationRequests,getSingleInvitation,
        toggleNewInvitationModalStatus,
        createInvitationRequest,retrieveAllInvitationRequests,
        getInvitationModalStatus
    }
})