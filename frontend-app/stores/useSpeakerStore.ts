import type {ConferenceData, ApiResponse, SpeakerData} from "~/types/interfaces";
import {map} from "yaml/dist/schema/common/map";
import type {ComputedRef} from "vue";

export const useSpeakerStore = defineStore('keySpeakerStore', () => {

    const openKeySpeakDialog = ref(false);
    const updatingData  = ref({})
    const eventSpeakers = ref([])
    const globalStore = useGlobalDataStore()

      const getSpeakers = computed(() => {return eventSpeakers.value})
      const getSpeakerModalStatus : ComputedRef = computed(() => {return openKeySpeakDialog.value})
      const getSpeakerTobeEdited : ComputedRef = computed(() => {return updatingData.value})

      // toggle loading
      const toggleKeySpeakerModal = (state:boolean) => openKeySpeakDialog.value = state
      const assignDataToBeUpdated = (speaker_data) => updatingData.value = speaker_data

      async function retrieveConferenceSpeakers(){
        const {data, error} = await useApiFetch(`/api/conference-speakers`);
        const response = data.value as ApiResponse
        if(response.code === 200){
          globalStore.toggleLoadingState('off')
          eventSpeakers.value = response.data
        }
        return {data, error};
      }
      async function createUpdateSpeaker(passedItem: SpeakerData, action: string = 'create') : Promise{
        const {data, error} = await useApiFetch(`/api/${action}-conference-speaker`,{
            method: 'POST',
            body : passedItem
        });
        const dataResponse : ApiResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
            globalStore.toggleBtnLoadingState(false)
          globalStore.assignAlertMessage(dataResponse?.message,'success')
          openKeySpeakDialog.value = false;
          await retrieveConferenceSpeakers()
        }else{
            globalStore.toggleBtnLoadingState(false)
        }
        return {data, error};
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
        
      toggleKeySpeakerModal,getSpeakerModalStatus,
        getSpeakerTobeEdited,
        assignDataToBeUpdated,
         openKeySpeakDialog,retrieveConferenceSpeakers,
         getSpeakers,
         createUpdateSpeaker,
          handleActivateHonorable,
        }
    })