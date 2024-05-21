import type { ApiResponse } from "~/types/interfaces";

export const useSiteDataStore = defineStore('siteData', () => {
      //states
    const siteData = ref<ApiResponse | null>(null);
    const siteError = ref<any>(null)

    //computed
    const getSitedData = computed(()=> siteData.value)
    const getSitedDataErrors = computed(()=> siteError.value)

    //Action
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
         
        }
    })