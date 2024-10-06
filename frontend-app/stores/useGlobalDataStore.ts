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
    const locations = ref(null)
    const districts = ref([])
    const isHanceLoader = ref(true)
    const isContentLoading = ref(false)
    const statisticData = ref([])
    const btnLoaderStatus = ref(false)

    const appRoutes  = ref([
        {name: 'Dashboard', path: '/crm/', userRole: '', isActiveLink:true},
        {name: 'All Events', path: '/crm/events', userRole: '', isActiveLink:false},
        {name: 'My Booking', path: '/crm/events/my-booking', userRole: '', isActiveLink:false},
        {name: 'My Invoices', path: '/crm/payments', userRole: '', isActiveLink:false},
        {name: 'All Bills', path: '/crm/payments/generated-bills', userRole: 'admin', isActiveLink:false},
        {name: 'Payments', path: '/crm/payments/settled-payments', userRole: 'admin', isActiveLink:false},
        // {name: 'Group Booking', path: '/crm/group-booking', userRole: '', isActiveLink:false},
        {name: 'Key Speakers', path: '/crm/speakers', userRole: '', isActiveLink:false},
        {name: 'Schedules', path: '/crm/schedules', userRole: 'admin', isActiveLink:false},
        {name: 'System Users', path: '/crm/users', userRole: 'admin', isActiveLink:false},
        {name: 'Agenda', path: '/crm/agenda', userRole: 'admin', isActiveLink:false},
        {name: 'Sponsors', path: '/crm/sponsors', userRole: 'admin', isActiveLink:false},
        {name: 'Exhibition Booking', path: '/crm/exhibition-booking', userRole: '', isActiveLink:false},
        {name: 'Invitation Letters', path: '/crm/invitation-letters', userRole: '', isActiveLink:false},
        {name: 'Documents', path: '/crm/documents', userRole: '', isActiveLink:false},
        {name: 'Ask Questions', path: '/crm/support/', userRole: '', isActiveLink:false},
        // {name: 'Support Responses', path: '/crm/support/response', userRole: 'admin', isActiveLink:false},
        // {name: 'Uploads', path: '/crm/documents/upload', userRole: 'admin', isActiveLink:false},
        {name: 'Gateway Bills', path: '/crm/payments/gateway-bills-requests', userRole: 'admin', isActiveLink:false},
        {name: 'System Reports', path: '/crm/reports', userRole: 'admin', isActiveLink:false},
        {name: 'Configuration', path: '/crm/system-configurations', userRole: 'admin', isActiveLink:false},
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
    const getRegions = computed(() => {return locations.value?.regions})
    const getDistricts = computed(() => {return districts.value})
    const getNations = computed(() => {return locations.value?.nations})
    const getLocalLoaderStatus = computed(() => {return localLoader.value})
    const getHanceLoaderState = computed(() => {return isHanceLoader.value})
    const getContentLoadingState = computed(() => {return isContentLoading.value})
    const getAdminStatisticalData = computed(() => {return statisticData.value?.admin})
    const getOthersStatisticalData = computed(() => {return statisticData.value?.attendee})
    const getBtnLoaderStatus = computed(() => {return btnLoaderStatus.value})



    // Transforms
    const toggleLoadingState = (key)=> key == 'on' ? isLoading.value = true : isLoading.value = false
    const toggleContentLoaderState = (key)=> key == 'on' ? isContentLoading.value = true : isContentLoading.value = false
    const toggleUserInfoDialogStatus = (key)=> key == 'on' ? userInfoDialogStatus.value = true :userInfoDialogStatus.value = false
    const hanceLoaderTurn = (key)=> (key == 'on') ? isHanceLoader.value = true: isHanceLoader.value = false;
    const toggleBtnLoadingState =  (state : boolean)=> btnLoaderStatus.value = state;

    const toggleRegistrationForm = (state:boolean)=> { registrationDialogStatus.value = state  }
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
        const elementNotify = () => {
            ElNotification({
                title: 'Alert',
                showClose: false,
                offset: 5,
                message: message,
                type: type,
                position: 'bottom-right',
            })
        }
        elementNotify()
        }

    async function retrieveLocation(){
        const {data,error} = await useApiFetch('/api/get-locations');
        if(data.value){
            locations.value = data.value?.data
        }
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
    function shortenText(text, wordLimit) {
        const words = text.split(' ');
        if (words.length > wordLimit) {
            return words.slice(0, wordLimit).join(' ') + '...';
        }
        return text;  // Return original text if it's already short enough
    }
    const analyticData = async ()=> {
        const {data,error} = await useApiFetch(`/api/analytics-data`);
        if(data.value){
            statisticData.value = data.value?.data
        }
        if (error.value){
            console.log(error.value)
        }
    }

    return {
        longName,
        setActiveLink,
        getRegistrationModalStatus,getLoadingState,getUserInfoModalStatus,
        toggleRegistrationForm,toggleLoadingState,toggleUserInfoModal,
        getSuccessStatus,getDangerStatus,getWarningStatus,toggleUserInfoDialogStatus,
        assignAlertMessage,toggleShowMessage,getAlertMessage,getAppRoute,
        getDistricts,retrieveRegionDistricts, hasPermission,
        separateNumber,getUserProfileStatus,toggleUserProfileModalStatus,
        getConfirmToAttendModalStatus,toggleConfirmToAttendModalStatus,
        getDoneCheckVisibility,toggleDoneCheckVisibility,hanceLoaderTurn,
        getLocalLoaderStatus, toggleLocalLoaderStatus,getHanceLoaderState,
        getForgotPassModalStatus, toggleForgotPassDialog,
        retrieveLocation,getNations,getRegions,getContentLoadingState,toggleContentLoaderState,
        analyticData, getAdminStatisticalData,getOthersStatisticalData,
        shortenText,
        getBtnLoaderStatus, toggleBtnLoadingState
    }
})