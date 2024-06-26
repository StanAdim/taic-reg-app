import type {ConferenceData, ApiResponse, SpeakerData} from "~/types/interfaces";
import {map} from "yaml/dist/schema/common/map";

export const useSpeakerStore = defineStore('keySpeakerStore', () => {

    const openKeySpeakDialog = ref(false);
    const eventSpeakers = ref([])
    const globalStore = useGlobalDataStore()

      const getSpeakers = computed(() => {return eventSpeakers.value})

      // toggle loading
      const toggleKeySpeakerModal = (key: string = 'close')=> {
        if(key === 'open') openKeySpeakDialog.value = true
        if(key === 'close') openKeySpeakDialog.value = false
      }

      async function retrieveConferenceSpeakers(){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/conference-speakers`);
        const response = data.value as ApiResponse
        if(response.code === 200){
          globalStore.toggleLoadingState('off')
          eventSpeakers.value = response.data
        }
        return {data, error};
      }
      async function createUpdateSpeaker(passedItem: SpeakerData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passedItem.action
          const mappedData = new FormData()
          mappedData.append('id',passedItem.id);
          mappedData.append('conference_id',passedItem.conference_id);
          mappedData.append('name',passedItem.name);
          mappedData.append('email',passedItem.email);
          mappedData.append('linkedinLink',passedItem.linkedinLink);
          mappedData.append('imageFile',passedItem.imageFile);
        console.log(mappedData)
        // const {data, error} = await useApiFetch(`/api/${action}-conference-speaker`,{
        //     method: 'POST',
        //     body : passedItem
        // });
        // const dataResponse = data.value as ApiResponse
        // if(dataResponse?.code === 200){
        //   globalStore.toggleLoadingState('off')
        //   globalStore.assignAlertMessage(dataResponse?.message,'success')
        //   openKeySpeakDialog.value = false;
        //   await retrieveConferenceSpeakers()
        // }
        // return {data, error};
      }
      
      async function handleActivateHonorable(passId: string){
        globalStore.toggleLoadingState('on')
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/honorable-speaker/activate/${passId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.assignAlertMessage(dataResponse?.message,'success')
          openKeySpeakDialog.value = false;
          globalStore.toggleLoadingState('off')
            await retrieveConferenceSpeakers()
        }
        return {data, error};
      }
      
      return { 
        
          toggleKeySpeakerModal,
         openKeySpeakDialog,retrieveConferenceSpeakers,
         getSpeakers,
         createUpdateSpeaker,
          handleActivateHonorable,
        }
    })