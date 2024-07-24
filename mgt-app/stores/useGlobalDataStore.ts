import {integer} from "vscode-languageserver-types";

export const useGlobalDataStore = defineStore('globalData', () => {
    const authStore = useAuthStore()
    const registrationDialogStatus= ref(false);
    const forgotPassDialogStatus= ref(false);
    const localLoader = ref(false);
    const userInfoDialogStatus= ref(false);
    const userProfileModalStatus= ref(false);
    const confirmToAttendModalStatus= ref(false);
    const doneCheckVisibility= ref(false);
    const alertMessage = ref('');
    const isLoading = ref(false);
    const showSuccessStatus = ref(true);
    const showWarningStatus = ref(true);
    const showDangerStatus = ref(true);
    const longName = ref('ICTC Events System')
    const regions = ref([])
    const districts = ref([])

    const appRoutes  = ref([
        {name: 'Dashboard', path: '/crm/', userRole: '', isActiveLink:true},
        {name: 'All Events', path: '/crm/events', userRole: '', isActiveLink:false},
        {name: 'Key Speakers', path: '/crm/speakers', userRole: 'admin', isActiveLink:false},
        {name: 'Invoices', path: '/crm/payments', userRole: '', isActiveLink:false},
        {name: 'Schedules', path: '/crm/schedules', userRole: 'admin', isActiveLink:false},
        {name: 'System Users', path: '/crm/users', userRole: 'admin', isActiveLink:false},
        {name: 'Agenda', path: '/crm/agenda', userRole: 'admin', isActiveLink:false},
    ])

    //computed property
    const getAppRoute = computed(() => {return appRoutes.value})
    const getDoneCheckVisibility = computed(() => {return doneCheckVisibility.value})
    const getRegistrationModalStatus = computed(() => {return registrationDialogStatus.value})
    const getForgotPassModalStatus = computed(() => {return forgotPassDialogStatus.value})
    const getUserProfileStatus = computed(() => {return userProfileModalStatus.value})
    const getUserInfoModalStatus = computed(() => {return userInfoDialogStatus.value})
    const getConfirmToAttendModalStatus = computed(() => {return confirmToAttendModalStatus.value})
    const getLoadingState = computed(() => {return isLoading.value})
    const getSuccessStatus = computed(() => {return showSuccessStatus.value})
    const getDangerStatus = computed(() => {return showDangerStatus.value})
    const getWarningStatus = computed(() => {return showWarningStatus.value})
    const getAlertMessage = computed(() => {return alertMessage.value})
    const getRegions = computed(() => {return regions.value})
    const getDistricts = computed(() => {return districts.value})
    const getLocalLoaderStatus = computed(() => {return localLoader.value})


    // Transforms
    const toggleLoadingState = (key)=> {
        if(key == 'on')isLoading.value = true;
        if(key == 'off')isLoading.value = false;
    }
    const toggleUserInfoDialogStatus = (key)=> {
        if(key == 'on')userInfoDialogStatus.value = true;
        if(key == 'off')userInfoDialogStatus.value = false;
    }
    const toggleRegistrationForm = ()=> { registrationDialogStatus.value = !registrationDialogStatus.value  }
    const toggleForgotPassDialog = ()=> { forgotPassDialogStatus.value = !forgotPassDialogStatus.value  }
    const toggleDoneCheckVisibility = ()=> { doneCheckVisibility.value = !doneCheckVisibility.value  }
    const toggleUserInfoModal = ()=> { userInfoDialogStatus.value = !userInfoDialogStatus.value  }
    const toggleUserProfileModalStatus = ()=> { userProfileModalStatus.value = !userProfileModalStatus.value  }
    const toggleLocalLoaderStatus = ()=> { localLoader.value = !localLoader.value  }
    const toggleConfirmToAttendModalStatus = ()=> {
        confirmToAttendModalStatus.value = !confirmToAttendModalStatus.value
        doneCheckVisibility.value = false  }
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
    function separateNumber(passedNum) {
        if (passedNum === undefined || passedNum === null) {
            throw new TypeError("Input number is undefined or null");
        }

        if (typeof passedNum !== 'number' && typeof passedNum !== 'string') {
            throw new TypeError("Input must be a number or a string representing a number");
        }

        // Convert to number first if it's a string representing a number
        let num = Number(passedNum);
        if (isNaN(num)) {
            throw new TypeError("Input is not a valid number");
        }

        let numStr = num.toString();
        numStr = numStr.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return numStr;
    }

    const hasPermission = (permissionCode)=> {   return authStore.getUserPermissions.includes(permissionCode)}

    // Function to change isActiveLink value and set others to false
    function setActiveLink(path) {
        for (let i = 0; i < appRoutes.value.length; i++) {
            if (appRoutes.value[i].path === path) {
                appRoutes.value[i].isActiveLink = true;
            } else {
                appRoutes.value[i].isActiveLink = false;
            }
        }
    }

    return {
        longName,
        setActiveLink,
        getRegistrationModalStatus,getLoadingState,getUserInfoModalStatus,
        toggleRegistrationForm,toggleLoadingState,toggleUserInfoModal,
        getSuccessStatus,getDangerStatus,getWarningStatus,toggleUserInfoDialogStatus,
        assignAlertMessage,toggleShowMessage,getAlertMessage,getAppRoute,
        getRegions,getDistricts, retrieveRegions,retrieveRegionDistricts, hasPermission,
        separateNumber,getUserProfileStatus,toggleUserProfileModalStatus,
        getConfirmToAttendModalStatus,toggleConfirmToAttendModalStatus,
        getDoneCheckVisibility,toggleDoneCheckVisibility,
        getLocalLoaderStatus, toggleLocalLoaderStatus,
        getForgotPassModalStatus, toggleForgotPassDialog

    }
})