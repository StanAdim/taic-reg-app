export const useGlobalDataStore = defineStore('globalData', () => {

    const registrationDialogStatus= ref(false);
    const userInfoDialogStatus= ref(true);
    const alertMessage = ref('');
    const isLoading = ref(false);
    const showSuccessStatus = ref(true);
    const showWarningStatus = ref(true);
    const showDangerStatus = ref(true);
    const longName = ref('Tanzania Annual ICT Conference')
    const regions = ref([])
    const districts = ref([])

    //computed property
    const getRegistrationModalStatus = computed(() => {return registrationDialogStatus.value})
    const getUserInfoModalStatus = computed(() => {return userInfoDialogStatus.value})
    const getLoadingState = computed(() => {return isLoading.value})
    const getSuccessStatus = computed(() => {return showSuccessStatus.value})
    const getDangerStatus = computed(() => {return showDangerStatus.value})
    const getWarningStatus = computed(() => {return showWarningStatus.value})
    const getAlertMessage = computed(() => {return alertMessage.value})
    const getRegions = computed(() => {return regions.value})
    const getDistricts = computed(() => {return districts.value})


    // Transforms
    const toggleLoadingState = (key)=> {
        if(key == 'on')isLoading.value = true;
        if(key == 'off')isLoading.value = false;
    }
    const toggleRegistrationForm = ()=> { registrationDialogStatus.value = !registrationDialogStatus.value  }
    const toggleUserInfoModal = ()=> { userInfoDialogStatus.value = !userInfoDialogStatus.value  }
    const toggleShowMessage = (type)=> {
        switch (type) {
            case 'success': showSuccessStatus.value = !showSuccessStatus.value; break;
            case 'danger': showDangerStatus.value = !showDangerStatus.value; break;
            case 'warning':showWarningStatus.value = !showWarningStatus.value
        }
    }
    const assignAlertMessage = (message,type)=> {
        alertMessage.value = message
        toggleShowMessage(type)
        setTimeout(function() {
            toggleShowMessage(type)
            alertMessage.value = ''
        }, 5000);
        }
    async function retrieveRegions(){
        const {data,error} = await useApiFetch('/api/get-country-regions');
        if(data.value){regions.value = data.value?.data}
        return {data,error}
    }
    async function retrieveRegionDistricts(targetRegionId:string){
        const {data,error} = await useApiFetch(`/api/get-districts/${targetRegionId}`);
        if(data.value){
            districts.value = data.value?.data
            assignAlertMessage(data.value?.message,'success')
        }
        return {data,error}
    }
    return {
        longName,
        getRegistrationModalStatus,getLoadingState,getUserInfoModalStatus,
        toggleRegistrationForm,toggleLoadingState,toggleUserInfoModal,
        getSuccessStatus,getDangerStatus,getWarningStatus,
        assignAlertMessage,toggleShowMessage,getAlertMessage,
        getRegions,getDistricts, retrieveRegions,retrieveRegionDistricts
    }
})