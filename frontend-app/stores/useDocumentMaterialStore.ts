import type {ApiResponse, DocumentMaterial} from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

export const useDocumentMaterialStore = defineStore('documentStore', () => {

    const globalStore = useGlobalDataStore()
    //Stores
    const allDocuments= ref <DocumentMaterial[]>([]);
    const eventDocuments= ref <DocumentMaterial[]>([]);
    const documentUploadModalStatus= ref <boolean>(false);

    //Computed
    const getEventDocument = computed(() => {return eventDocuments.value})
    const getAllDocs = computed(() => {return allDocuments.value})
    const getDocumentUploadDialogStatus = computed(() => {return documentUploadModalStatus.value})

    //Actions
    const toggleDocumentUploadModalStatus = (state) =>  documentUploadModalStatus.value = state;
    const uploadNewDocument = async (passedData)=> {
        // Make the API request to upload the file
        await useApiFetch("/sanctum/csrf-cookie");
        try {
            for (let [key, value] of passedData.entries()) {
                console.log(`${key}:`, value);
            }
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

    return {
        getAllDocs,getEventDocument,
        getDocumentUploadDialogStatus,toggleDocumentUploadModalStatus,
        uploadNewDocument,retrieveAllDocuments
    }
})