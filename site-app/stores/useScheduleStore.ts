import type { ConferenceData,ApiResponse } from "~/types/interfaces";

export const useScheduleStore = defineStore('schedules', () => {

    const openDayDialog = ref(false);
    const openScheduleModal = ref(false);
    const openTimetableDialog = ref(false);
    const openActivityDialog = ref(false);

    const conferenceDays = ref([])
    const conferencetimetables = ref([])
    const conferenceActivities = ref([])

    const globalStore = useGlobalDataStore()
      const getScheduleModalStatus = computed(()=> {return openScheduleModal.value})
      const getConferenceDays = computed(() => {return conferenceDays.value})
      const getConferenceTimetables = computed(() => {return conferencetimetables.value})
      const getConferenceActivities = computed(() => {return conferenceActivities.value})

      // toogle dialogs 
      const toogleScheduleModal = (key: string = 'close')=> {
        if(key === 'open') openScheduleModal.value = true
        if(key === 'close') openScheduleModal.value = false
      }
      const toogleDayDialog = (key: string = 'close')=> {
        if(key === 'open') openDayDialog.value = true
        if(key === 'close') openDayDialog.value = false
      }
      const toogleTimetableDialog = (key: string = 'close')=> {
        if(key === 'open') openTimetableDialog.value = true
        if(key === 'close') openTimetableDialog.value = false
      }
      const toogleActivityDialog = (key: string = 'close')=> {
        if(key === 'open') openActivityDialog.value = true
        if(key === 'close') openActivityDialog.value = false
      }

      async function retriveConferenceSchedules(){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/conference-schedules`);
        const response = data.value as ApiResponse
        if(response.code = 200){
          globalStore.setLoadingTo('off')
          conferenceDays.value = response.data?.days
          conferencetimetables.value = response.data?.timetable
          conferenceActivities.value = response.data?.activities
        }
        return {data, error};
      }
      async function createUpdateDay(passedConfigration: ConferenceData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passedConfigration.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-day`,{
            method: 'POST',
            body : passedConfigration 
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.setLoadingTo('off')
          toogleDayDialog('close')
          globalStore.AssignNotificationMessage(dataResponse?.message)
          openDayDialog.value = false;
          retriveConferenceSchedules()
        }
        return {data, error};
      }
      async function createUpdateTimetable(passedConfigration: ConferenceData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passedConfigration.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-timetable`,{
            method: 'POST',
            body : passedConfigration 
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          globalStore.setLoadingTo('off')
          toogleTimetableDialog('close')
          globalStore.AssignNotificationMessage(dataResponse?.message)
          openDayDialog.value = false;
          retriveConferenceSchedules()
        }
        return {data, error};
      }
      
      async function createUpdateActivity(passedConfigration: ConferenceData){
        await useApiFetch("/sanctum/csrf-cookie");
        const action = passedConfigration.action
        const {data, error} = await useApiFetch(`/api/${action}-conference-activity`,{
            method: 'POST',
            body : passedConfigration 
        });
        const dataResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
          toogleActivityDialog('close')
          globalStore.setLoadingTo('off')
          globalStore.AssignNotificationMessage(dataResponse?.message)
          openDayDialog.value = false;
          retriveConferenceSchedules()
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
          openDayDialog.value = false;
          globalStore.setLoadingTo('off')
          retriveConferenceSchedules()
        }
        return {data, error};
      }
      
      return { 
         
        openDayDialog, openTimetableDialog,openActivityDialog,
          toogleDayDialog,toogleTimetableDialog, toogleActivityDialog,
         retriveConferenceSchedules,
         getConferenceDays,getConferenceTimetables,getConferenceActivities,
         createUpdateDay,createUpdateTimetable,createUpdateActivity,
         handleActivateHorouble,
         getScheduleModalStatus, toogleScheduleModal
        }
    })