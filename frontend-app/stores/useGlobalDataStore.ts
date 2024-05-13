export const useGlobalDataStore = defineStore('glogalData', () => {


    const registrationDialogStatus= ref(false);
    const isLoading = ref(false);
    const longName = ref('Tanzania Annual ICT Conference')

    //computed property
    const getRegistrationModalStatus = computed(() => {return registrationDialogStatus.value})
    const getLoadingState = computed(() => {return isLoading.value})


    // Transforms
    const toggleLoadingState = (key)=> {
        if(key == 'on')isLoading.value = true;
        if(key == 'off')isLoading.value = false;
    }
    const toggleRegistrationForm = ()=> { registrationDialogStatus.value = !registrationDialogStatus.value  }

    return {
        longName,
        getRegistrationModalStatus,getLoadingState,
        toggleRegistrationForm,toggleLoadingState
    }
})