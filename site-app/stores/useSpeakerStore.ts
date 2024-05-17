import type { ConferenceData,ApiResponse } from "~/types/interfaces";

export const useSpeakerStore = defineStore('keySpeakerStore', () => {

    const openKeySpeakDialog = ref(false);
    const conferenceSpeakers = ref([])
    const globalStore = useGlobalDataStore()

      const getSpeakers = computed(() => {return conferenceSpeakers.value})

      // toogle laoding 
      const toogleDialog = (key: string = 'close')=> {
        if(key === 'open') openKeySpeakDialog.value = true
        if(key === 'close') openKeySpeakDialog.value = false
      }

      async function retriveConferenceSpeakers(){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/conference-speakers`);
        const response = data.value as ApiResponse
        if(response.code = 200){
          globalStore.setLoadingTo('off')
          conferenceSpeakers.value = response.data 
        }
        return {data, error};
      }
      async function createUpdateSpeaker(passedConfigration: ConferenceData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passedConfigration.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-speaker`,{
            method: 'POST',
            body : passedConfigration 
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.setLoadingTo('off')
          globalStore.AssignNotificationMessage(dataResponse?.message)
          openKeySpeakDialog.value = false;
          retriveConferenceSpeakers()
        }
        return {data, error};
      }
      
      async function handleActivateHorouble(passId: string){
        globalStore.setLoadingTo('on')
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/honorable-speaker/activate/${passId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.AssignNotificationMessage(dataResponse?.message)
          openKeySpeakDialog.value = false;
          globalStore.setLoadingTo('off')
          retriveConferenceSpeakers()
        }
        return {data, error};
      }
      
      return { 
        
          toogleDialog,
         openKeySpeakDialog,retriveConferenceSpeakers,
         getSpeakers,
         createUpdateSpeaker,
         handleActivateHorouble,
        }
    })