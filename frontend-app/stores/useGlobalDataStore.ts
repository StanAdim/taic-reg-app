export const useGlobalDataStore = defineStore('glogalData', () => {


    const registrationDialogStatus= ref(false);
    const alertMessage = ref('');
    const isLoading = ref(false);
    const showSuccessStatus = ref(true);
    const showWarningStatus = ref(true);
    const showDangerStatus = ref(true);
    const longName = ref('Tanzania Annual ICT Conference')

    //computed property
    const getRegistrationModalStatus = computed(() => {return registrationDialogStatus.value})
    const getLoadingState = computed(() => {return isLoading.value})
    const getSuccessStatus = computed(() => {return showSuccessStatus.value})
    const getDangerStatus = computed(() => {return showDangerStatus.value})
    const getWarningStatus = computed(() => {return showWarningStatus.value})
    const getAlertMessage = computed(() => {return alertMessage.value})


    // Transforms
    const toggleLoadingState = (key)=> {
        if(key == 'on')isLoading.value = true;
        if(key == 'off')isLoading.value = false;
    }
    const toggleRegistrationForm = ()=> { registrationDialogStatus.value = !registrationDialogStatus.value  }
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

    return {
        longName,
        getRegistrationModalStatus,getLoadingState,
        toggleRegistrationForm,toggleLoadingState,
        getSuccessStatus,getDangerStatus,getWarningStatus,
        assignAlertMessage,toggleShowMessage,getAlertMessage
    }
})