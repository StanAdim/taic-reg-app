import type { ConferenceData,ApiResponse } from "~/types/interfaces";

export const useConfigurationStore = defineStore('configurationStore', () => {

    const configurationDialogStatus = ref(false);
    const taicConferences = ref([])
    const globalStore = useGlobalDataStore()
   
      const getYearsArray = computed(() => {
        const currentYear = new Date().getFullYear();
        const startYear = currentYear;
        const yearsArray = [];
        for (let year = startYear; year <= 2040; year++) {
          yearsArray.push(year);
        }
        return yearsArray;
      })
      const getConferences = computed(() => {return taicConferences.value})

      // toogle laoding 
      const toogleDialog = ()=> {
        return configurationDialogStatus.value = !configurationDialogStatus.value
      }

      async function retriveConferences(){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/taic-conferences`);
        const response = data.value as ApiResponse
        if(response.code = 200){
          globalStore.setLoadingTo('off')
          taicConferences.value = response.data 
        }
        return {data, error};
      }
      async function createUpdateConfiguration(passedConfigration: ConferenceData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passedConfigration.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-data`,{
            method: 'POST',
            body : passedConfigration 
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.setLoadingTo('off')
          globalStore.AssignNotificationMessage(dataResponse?.message)
          configurationDialogStatus.value = false;
          retriveConferences()
        }
        return {data, error};
      }
      
      async function handleConferenceActivation(passId: string){
        globalStore.setLoadingTo('on')
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/conference/activate/${passId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.AssignNotificationMessage(dataResponse?.message)
          configurationDialogStatus.value = false;
          globalStore.setLoadingTo('off')
          retriveConferences()
        }
        return {data, error};
      }
      
      return { 
        
          toogleDialog,getYearsArray,
         configurationDialogStatus,retriveConferences,
         getConferences,
         createUpdateConfiguration,
         handleConferenceActivation,
        }
    })