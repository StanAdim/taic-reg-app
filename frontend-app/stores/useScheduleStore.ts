import type { ConferenceData,ApiResponse } from "~/types/interfaces";

export const useScheduleStore = defineStore('schedules', () => {

    const openDayDialog = ref(false);
    const openScheduleModal = ref(false);
    const openTimetableDialog = ref(false);
    const openActivityDialog = ref(false);

    const conferenceDays = ref([])
    const conferenceTimetable = ref([])
    const conferenceActivities = ref([])

    const globalStore = useGlobalDataStore()
      const getScheduleModalStatus = computed(()=> {return openScheduleModal.value})
      const getConferenceDays = computed(() => {return conferenceDays.value})
      const getConferenceTimetables = computed(() => {return conferenceTimetable.value})
      const getConferenceActivities = computed(() => {return conferenceActivities.value})

      // toggle dialogs
      const toggleScheduleModal = (key: string = 'close')=> {
        if(key === 'open') openScheduleModal.value = true
        if(key === 'close') openScheduleModal.value = false
      }
      const toggleDayDialog = (key: string = 'close')=> {
        if(key === 'open') openDayDialog.value = true
        if(key === 'close') openDayDialog.value = false
      }
      const toggleTimetableDialog = (key: string = 'close')=> {
        if(key === 'open') openTimetableDialog.value = true
        if(key === 'close') openTimetableDialog.value = false
      }
      const toggleActivityDialog = (key: string = 'close')=> {
        if(key === 'open') openActivityDialog.value = true
        if(key === 'close') openActivityDialog.value = false
      }

      async function retrieveConferenceSchedules(){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/conference-schedules`);
        const response = data.value as ApiResponse
        if(response.code === 200){
          globalStore.toggleLoadingState('off')
          conferenceDays.value = response.data?.days
          conferenceTimetable.value = response.data?.timetable
          conferenceActivities.value = response.data?.activities
        }
        return {data, error};
      }
      async function createUpdateDay(passedItem: ConferenceData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passedItem.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-day`,{
            method: 'POST',
            body : passedItem
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.toggleLoadingState('off')
          toggleDayDialog('close')
          globalStore.assignAlertMessage(dataResponse?.message,'success')
          openDayDialog.value = false;
          await retrieveConferenceSchedules()
        }
        return {data, error};
      }
      async function createUpdateTimetable(passedItem: ConferenceData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passedItem.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-timetable`,{
            method: 'POST',
            body : passedItem
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.toggleLoadingState('off')
          toggleTimetableDialog('close')
          globalStore.assignAlertMessage(dataResponse?.message,'success')
          openDayDialog.value = false;
          await retrieveConferenceSchedules()
        }
        return {data, error};
      }
      
      async function createUpdateActivity(passedItem: ConferenceData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passedItem.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-activity`,{
            method: 'POST',
            body : passedItem
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          toggleActivityDialog('close')
          globalStore.toggleLoadingState('off')
          globalStore.assignAlertMessage(dataResponse?.message,'success')
          openDayDialog.value = false;
          await retrieveConferenceSchedules()
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
          openDayDialog.value = false;
          globalStore.toggleLoadingState('off')
          await retrieveConferenceSchedules()
        }
        return {data, error};
      }
      async function handleTimeSlotCall(passId: string){
        globalStore.toggleLoadingState('on')
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/retrive-timetable/${passId}`);
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.assignAlertMessage(dataResponse?.message,'success')
          openDayDialog.value = false;
          globalStore.toggleLoadingState('off')
          await retrieveConferenceSchedules()
        }
        return {data, error};
      }
      
      return { 
         
        openDayDialog, openTimetableDialog,openActivityDialog,
          toggleDayDialog,toggleTimetableDialog, toggleActivityDialog,
         retrieveConferenceSchedules,
         getConferenceDays,getConferenceTimetables,getConferenceActivities,
         createUpdateDay,createUpdateTimetable,createUpdateActivity,
         handleActivateHonorable,
         getScheduleModalStatus, toggleScheduleModal
        }
    })