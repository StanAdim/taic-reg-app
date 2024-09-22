import type {ApiResponse, DocumentMaterial} from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

export const useDocumentMaterialStore = defineStore('documentStore', () => {

    const globalStore = useGlobalDataStore()
    //Stores
    const allDocuments= ref <DocumentMaterial[]>([]);
    const eventDocuments= ref <DocumentMaterial[]>([]);
    const documentUploadModalStatus= ref <boolean>(false);
    const docPreviewModal= ref <boolean>(false);

    //Computed
    const getEventDocument = computed(() => {return eventDocuments.value})
    const getAllDocs = computed(() => {return allDocuments.value})
    const getDocumentUploadDialogStatus = computed(() => {return documentUploadModalStatus.value})
    const getPreviewModalStatus = computed(() => docPreviewModal.value);

    //Actions
    const togglePreviewModalStatus = (newState: boolean) => docPreviewModal.value = newState;
    const toggleDocumentUploadModalStatus = (state) =>  documentUploadModalStatus.value = state;
    const uploadNewDocument = async (passedData)=> {
        // Make the API request to upload the file
        await useApiFetch("/sanctum/csrf-cookie");
        try {
            const { data, error } = await useApiFetch('/api/upload-document', {
                method: 'POST',
                body: passedData,
                headers: {
                    // 'Content-Type': "multipart/form-data"
                }
            });
            if(data.value){
                const message = 'Document uploaded successfully!';
                await  retrieveAllDocuments()
                toggleDocumentUploadModalStatus(false)
                globalStore.toggleBtnLoadingState(false);
                globalStore.assignAlertMessage(message, 'success');
            }
            if(error.value){
                globalStore.toggleBtnLoadingState(false);
                globalStore.assignAlertMessage(error.value?.message, 'error');
            }
        } catch (err) {
            console.log(error)
            const message = 'Failed to upload document.';
            globalStore.toggleBtnLoadingState(false);
            globalStore.assignAlertMessage(message, 'error');
        }
    }
    async function retrieveAllDocuments() {
        globalStore.toggleContentLoaderState('on')
        const { data, error } = await useApiFetch(`/api/events-documents`);
        if(data.value){
            allDocuments.value = data.value?.data;
            globalStore.toggleContentLoaderState('off');
        }
        else {
            globalStore.toggleContentLoaderState('off');
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
        }
    }
    async function deleteDoc(docId : string) : Promise {
        globalStore.toggleContentLoaderState('on')
        const { data, error } = await useApiFetch(`/api/events-document-delete-${docId}`, {
            method: 'DELETE'
        });
        if(data.value){
            await  retrieveAllDocuments()
            globalStore.toggleContentLoaderState('off');
        }
        else {
            globalStore.toggleContentLoaderState('off');
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
        }
    }
    async function updateDocStatus(docId : string) : Promise {
            globalStore.toggleContentLoaderState('on')
            const { data, error } = await useApiFetch(`/api/events-document-update-${docId}`, {
                method: 'PUT'
            });
            if(data.value){
                await  retrieveAllDocuments()
                globalStore.toggleContentLoaderState('off');
            }
            else {
                globalStore.toggleContentLoaderState('off');
                globalStore.assignAlertMessage(error.value?.data?.message, 'error')
            }
        }

    return {
        getAllDocs,getEventDocument,
        getDocumentUploadDialogStatus,toggleDocumentUploadModalStatus,
        uploadNewDocument,retrieveAllDocuments,
        togglePreviewModalStatus,getPreviewModalStatus,
        deleteDoc,updateDocStatus,
    }
})