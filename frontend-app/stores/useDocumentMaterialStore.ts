import type {ApiResponse, DocumentMaterial} from "~/types/interfaces";

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
        try {
            const { data, error } = await useApiFetch('/api/upload-document', {
                method: 'POST',
                body: passedData,
            });
            if (error.value) {
                globalStore.assignAlertMessage(error.value?.message, 'error')
                throw error.value;
            }
            const message = 'Document uploaded successfully!';
            globalStore.assignAlertMessage(message, 'success');
        } catch (err) {
            console.error(err);
            const message = 'Failed to upload document.';
            globalStore.assignAlertMessage(message, 'error');
        }    }
    const handleEventDocument = async ()=> {
        console.log(passedUserInfo)
    }
    return {
        getEventDocument,getSystemDocument,
        uploadNewDocument,handleEventDocument

    }
})