import type {ApiResponse, DocumentMaterial} from "~/types/interfaces";

export const useDocumentMaterialStore = defineStore('documentStore', () => {

    //Stores
    const allDocument= ref <DocumentMaterial[]>([]);
    const eventDocuments= ref <DocumentMaterial[]>([]);

    //Computed
    const getSystemDocument = computed(() => {return eventDocuments.value})
    const getEventDocument = computed(() => {return allDocument.value})

    //Actions
    const uploadNewDocument = async (passedData)=> {
        console.log(passedData)
    }
    const handleEventDocument = async ()=> {
        console.log(passedUserInfo)
    }
    return {
        getEventDocument,getSystemDocument,
        uploadNewDocument,handleEventDocument

    }
})