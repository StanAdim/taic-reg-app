import type {ApiResponse, LoggedUser} from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

export const useUserStore = defineStore('userStore', () => {

    const globalStore = useGlobalDataStore()
    const systemUserDetail = ref(null)
    const professionalList = ref(null)
    const regModalStatus = ref(false)
    const importModalStatus = ref(false)

    const getSystemUserDetail = computed(() => {return systemUserDetail.value})
    const getProfessionalList = computed(() => {return professionalList.value})
    const getRegModalStatus : boolean = computed(() => {return regModalStatus.value})
    const getImportModalStatus : boolean = computed(() => {return importModalStatus.value})

    // Actions

    const toggleRegModalStatus = (state) => regModalStatus.value = state
    const toggleImportModalStatus = (state) => importModalStatus.value = state

    async function store(professional_data ) : Promise{
        const  {data, error} = await useApiFetch("/api/store-professional", {
            method: "POST",
            body: professional_data,
        });
        if(data.value){
            globalStore.toggleLoadingState('off')
            toggleRegModalStatus(false)
            await retrieveProfessionalList()
            globalStore.assignAlertMessage('Registration Success','success')
        }else{
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(error.value?.message, 'error')
        }
    }
    async function importExcel(passed_data ) : Promise{
        const  {data, error} = await useApiFetch("/api/import-professionals-excel", {
            method: "POST",
            body: passed_data,
        });
        if(data.value){
            globalStore.toggleBtnLoadingState(false)
            toggleImportModalStatus(false)
            await retrieveProfessionalList()
            globalStore.assignAlertMessage('Data Imported Success','success')
        }else{
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
        }
    }

    async function retrieveSystemUserDetail(user_key:string) : Promise{
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/system-user-${user_key}`);
        if(data.value){
            systemUserDetail.value = data.value?.data
        }else {
            console.log(error.value)
        }
        globalStore.toggleContentLoaderState('off')
    }
    async function retrieveProfessionalList(per_page: number = 12, page : number = 1, search : string = '') : Promise<[]>{
        globalStore.toggleContentLoaderState('on')
        const {data,error} = await useApiFetch(`/api/professional-list?per_page=${per_page}&page=${page}&search=${search}`);
        if(data.value){
            // globalStore.assignAlertMessage(data.value.message, 'success')
            professionalList.value = data.value?.data as LoggedUser
            globalStore.toggleContentLoaderState('off')

        }else {
            console.log(error.value)
            globalStore.toggleContentLoaderState('off')

        }
    }


    return {
        retrieveSystemUserDetail,
        getSystemUserDetail,
        toggleRegModalStatus,getRegModalStatus,
        getImportModalStatus,toggleImportModalStatus,importExcel,
        getProfessionalList, store,
        retrieveProfessionalList

    }
})