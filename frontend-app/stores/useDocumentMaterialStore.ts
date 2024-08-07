import type {ApiResponse, DocumentMaterial} from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

export const useDocumentMaterialStore = defineStore('documentStore', () => {

    const globalStore = useGlobalDataStore()
    //Stores
    const allDocument= ref <DocumentMaterial[]>([]);
    const eventDocuments= ref <DocumentMaterial[]>([]);

    //Computed
    const getSystemDocument = computed(() => {return eventDocuments.value})
    const getEventDocument = computed(() => {return allDocument.value})

    //Actions
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
    const handleEventDocument = async ()=> {
        console.log(passedUserInfo)
    }
    return {
        getEventDocument,getSystemDocument,
        uploadNewDocument,handleEventDocument

    }
})