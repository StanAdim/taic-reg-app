import type { ApiResponse } from "~/types/interfaces";

export const useSiteDataStore = defineStore('siteData', () => {
      //states
    const siteData = ref<ApiResponse | null>(null);
    const siteError = ref<any>(null)
    const eventSpeakers = ref<any>([])

    //computed
    const getSitedData = computed(()=> siteData.value)
    const getEventSpeakers = computed(()=> eventSpeakers.value)

    //Action
    async function retrieveConferenceSpeakers(){
        const {data, error} = await useApiFetch(`/api/site-conference-speakers`);
        const response = data.value as ApiResponse
        if(response.code === 200){
            eventSpeakers.value = response.data
        }
        return {data, error};
    }

    async function retrieveSiteDate() {
      const {data, error} = await useApiFetch('/api/site-data');
      const dataResponse = data.value as ApiResponse
      if(dataResponse.code === 200){
        siteData.value = dataResponse.data
      }
      // console.log(data,error);
      return {data, error}
    }
      
      return { 
          getSitedData,
          retrieveSiteDate,
          getEventSpeakers,
          retrieveConferenceSpeakers
         
        }
    })