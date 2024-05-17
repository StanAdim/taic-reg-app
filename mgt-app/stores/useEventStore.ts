import type { ConferenceData,ApiResponse } from "~/types/interfaces";

export const useEventStore = defineStore('eventStore', () => {

    const eventDialogStatus = ref(false);
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
        // toggle Loading
        const toggleLoading = ()=> {
        return eventDialogStatus.value = !eventDialogStatus.value
      }

      async function retrieveEvent(){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/taic-conferences`);
        const response = data.value as ApiResponse
        if(response.code == 200){
          globalStore.setLoadingTo('off')
          taicConferences.value = response.data 
        }
        return {data, error};
      }
      async function createUpdateConfiguration(passEvent: ConferenceData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passEvent.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-data`,{
            method: 'POST',
            body : passEvent
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.setLoadingTo('off')
          globalStore.AssignNotificationMessage(dataResponse?.message)
          eventDialogStatus.value = false;
          await retrieveEvent()
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
          eventDialogStatus.value = false;
          globalStore.setLoadingTo('off')
          await retrieveEvent()
        }
        return {data, error};
      }

      return {
        toggleLoading,getYearsArray,
         eventDialogStatus,retrieveEvent,
         getConferences,
         createUpdateConfiguration,
         handleConferenceActivation,
        }
    })