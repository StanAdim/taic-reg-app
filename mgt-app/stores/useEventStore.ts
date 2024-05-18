import type { ConferenceData,ApiResponse } from "~/types/interfaces";

export const useEventStore = defineStore('eventStore', () => {

    const eventDialogStatus = ref(false);
    const events = ref([])
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
        // toggle Loading
        const toggleEventModal = ()=> { return eventDialogStatus.value = !eventDialogStatus.value }

      async function retrieveEvents(){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/taic-conferences`);
        const response = data.value as ApiResponse
        if(response.code == 200){
          globalStore.toggleLoadingState('off')
          globalStore.assignAlertMessage(response?.message,'success')
          events.value = response.data
        }
        return {data, error};
      }
      async function createUpdateEvent(passEvent: ConferenceData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passEvent.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-data`,{
            method: 'POST',
            body : passEvent
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.toggleLoadingState('off')
          globalStore.assignAlertMessage(dataResponse?.message,'success')
          eventDialogStatus.value = false;
          await retrieveEvents()
        }
        return {data, error};
      }
      
      async function handleConferenceActivation(passId: string){
        globalStore.toggleLoadingState('on')
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/conference/activate/${passId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.assignAlertMessage(dataResponse?.message, 'success')
          eventDialogStatus.value = false;
          globalStore.toggleLoadingState('off')
          await retrieveEvents()
        }
        return {data, error};
      }
      async function fetchSingleEvent(eventId: string){
        await useApiFetch("/sanctum/csrf-cookie");
        globalStore.toggleLoadingState('on')
        const {data, error} = await useApiFetch(`/api/conference-data/${eventId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          singleEventDetail.value = dataResponse.data
          globalStore.assignAlertMessage(dataResponse?.message, 'success')
          globalStore.toggleLoadingState('off')
        }
        return {data, error};
      }

      return {
        toggleEventModal,getYearsArray,
         eventDialogStatus,retrieveEvents,
        getEvents,
         createUpdateEvent,getSingleEventDetail,
         handleConferenceActivation,fetchSingleEvent
        }
    })