export const useGlobalDataStore = defineStore('glogalData', () => {


    const registrationDialogStatus= ref(true);
    const longName = ref('Tanzania Annual ICT Conference')

    //computed property
    const getRegistrationModalStatus = computed(() => {return registrationDialogStatus.value})


    // toggle  loading
    const toggleRegistrationForm = ()=> { registrationDialogStatus.value = !registrationDialogStatus.value  }

    return {
        longName,
        getRegistrationModalStatus,
        toggleRegistrationForm
    }
})