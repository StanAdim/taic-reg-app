import type { ConferenceData,ApiResponse } from "~/types/interfaces";

export const useEventStore = defineStore('eventStore', () => {

    const eventDialogStatus = ref(false);
    const events = ref([])
    const upComingEvents = ref([])
    const singleEventDetail = ref<ConferenceData | null>(null)
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
        const getEvents = computed(() => {return events.value})
        const getSingleEventDetail = computed(() => {return singleEventDetail.value})
        const getUpComingEvents = computed(() => {return upComingEvents.value})
        // toggle Loading
        const toggleEventModal = ()=> { return eventDialogStatus.value = !eventDialogStatus.value }

      async function retrieveEvents(){
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/taic-conferences`);
        const response = data.value as ApiResponse
        if(response.code == 200){
          globalStore.toggleLoadingState('off')
          globalStore.toggleContentLoaderState('off')
          events.value = response.data
        }
        return {data, error};
      }
      async function createUpdateEvent(passEvent: ConferenceData) : Promise{
       const action = passEvent.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-data`,{
            method: 'POST',
            body : passEvent
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.toggleBtnLoadingState(false)
          globalStore.assignAlertMessage(dataResponse?.message,'success')
          eventDialogStatus.value = false;
          await retrieveEvents()
        }
        else
        {
          globalStore.toggleBtnLoadingState(false)
          console.log(error.value)
        }
        return {data, error};
      }
      
      async function handleConferenceActivation(passId: string){
        globalStore.toggleLoadingState('on')
        const {data, error} = await useApiFetch(`/api/conference/activate/${passId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.assignAlertMessage(dataResponse?.message, 'success')
          eventDialogStatus.value = false;
          globalStore.toggleLoadingState('off')
          await retrieveEvents()
        }
      }      async function handleConferenceShowStatus (passId: string){
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/conference/change-status/${passId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.assignAlertMessage(dataResponse?.message, 'success')
          eventDialogStatus.value = false;
          globalStore.toggleContentLoaderState('off')
          await retrieveEvents()
        }
      }
      async function fetchSingleEvent(eventId: string){
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/conference-data/${eventId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          singleEventDetail.value = dataResponse.data
          globalStore.toggleContentLoaderState('off')
        }
        return {data, error};
      }
      async function handleUpComingEvents(){
        globalStore.toggleLoadingState('on')
        const {data, error} = await useApiFetch(`/api/get-upcoming-events`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          upComingEvents.value = dataResponse.data
          globalStore.toggleLoadingState('off')
        }
        return {data, error};
      }

      return {
        toggleEventModal,getYearsArray,getUpComingEvents,
         eventDialogStatus,retrieveEvents,
          getEvents,handleUpComingEvents,
         createUpdateEvent,getSingleEventDetail,
         handleConferenceActivation,fetchSingleEvent,
        handleConferenceShowStatus
        }
    })