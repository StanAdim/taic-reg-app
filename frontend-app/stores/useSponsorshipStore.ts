import type {ConferenceData, ApiResponse, SponsorData} from "~/types/interfaces";

export const useSponsorshipStore = defineStore('sponsorship', () => {

    const openSponsorDialog = ref(false);
    const updatingData  = ref({})
    const singleSponsor  = ref({})
    const eventSponsors = ref([])
    const globalStore = useGlobalDataStore()

      const getSponsors = computed(() => {return eventSponsors.value})
      const getSponsorModalStatus : ComputedRef = computed(() => {return openSponsorDialog.value})
      const getSponsorTobeEdited : ComputedRef = computed(() => {return updatingData.value})
      const getSponsorData : ComputedRef = computed(() => {return singleSponsor.value})

      // toggle modals
      const toggleSponsorModal = (state:boolean) => openSponsorDialog.value = state
      const assignDataToBeUpdated = (speaker_data) => updatingData.value = speaker_data

    // Mutation
      async function retrieveConferenceSponsors(type:string = '1') : Promise{
        const {data, error} = await useApiFetch(`/api/sponsorship?category=${type}`);
        if(data.value){
          globalStore.toggleLoadingState('off')
          eventSponsors.value = data.value?.data
        }
      }
      async function createUpdateSponsor(passedItem: SponsorData, action: string = 'create') : Promise{
        const {data, error} = await useApiFetch(`/api/sponsorship`,{
            method: action  === 'create' ? 'POST': 'PUT',
            body : passedItem
        });
        const dataResponse : ApiResponse = data.value as ApiResponse
        if(dataResponse?.code === 200){
            globalStore.toggleBtnLoadingState(false)
          globalStore.assignAlertMessage(dataResponse?.message,'success')
          openSponsorDialog.value = false;
          await retrieveConferenceSponsors()
        }else{
            globalStore.toggleBtnLoadingState(false)
        }
      }
      async function retrieveSingleSponsor(passId: string) : Promise{
          globalStore.toggleContentLoaderState('on')
          const {data, error} = await useApiFetch(`/api/conference-speaker/${passId}`);
          if(data.value){
              // console.log(data.value?.data)
              singleSponsor.value = data.value?.data
          }else {
              console.log(error.value)
          }
          globalStore.toggleContentLoaderState('off')
      }
      async function toggleSponsorVisibility(passId: string) : Promise{
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/sponsorship/${passId}`);
        if(data.value){
            globalStore.assignAlertMessage(data.value.message, 'success')
            await  retrieveConferenceSponsors();
        }else {
            console.log(error.value)
        }
        globalStore.toggleContentLoaderState('off')
    }

    return {
      toggleSponsorModal,getSponsorModalStatus,
        getSponsorTobeEdited,
        assignDataToBeUpdated,
         openSponsorDialog,retrieveConferenceSponsors,
         getSponsors,
         createUpdateSponsor,
          retrieveSingleSponsor,
            getSponsorData,
            toggleSponsorVisibility,
        }
    })