import type {Credential, LoggedUser, User} from "~/types/interfaces";
import {defineStore} from "pinia";
import {useApiFetch} from "~/composables/useApiFetch";
export const useAuthStore = defineStore('auth', ()=> {
    const accountStore = useAccountStore()
    const  user = ref<User | null>(null)
    const isLoggedIn = computed(()=> !!user.value)
    const globalStore = useGlobalDataStore()
    const authErrors = ref <any | null>(null)
    const appUsers = ref <any>([])
    const professionalDetails = ref <any>(null)

    const getLoggedUser = computed(()=>{return user.value?.user})
    const getProfessionalDetails = computed(()=>{return professionalDetails.value})
    const getLoggedUserInfo = computed(()=>{return user.value?.userInfo})
    const getAppUsers = computed(()=>{return appUsers.value?.data})
    const getAuthErrors = computed(()=>{return authErrors.value})
    const getUserRole = computed(()=>{return user.value?.role?.name})
    const getUserPermissions = computed(()=>{
        return  user.value?.role?.permissions.map(obj => obj.code)})
    //Fetch Logout
    async function fetchUser(){
        const {data,error} = await useApiFetch('/api/auth/user');
        if(data.value){
            globalStore.toggleLoadingState('off')
            user.value = data.value as LoggedUser
            if(getLoggedUser.value?.hasInfo == 0)globalStore.toggleUserInfoDialogStatus('on') //close Extra infoDialog
        }
        if (error.value){
            console.log(error.value.message, 'error')
        }
        return {data,error}
    }
    //Fetch Application Users
    async function retrieveAppUsers(per_page: number = 12, page : number = 1, search : string = '') : Promise<[]>{
        globalStore.toggleContentLoaderState('on')
        const {data,error} = await useApiFetch(`/api/application-users?per_page=${per_page}&page=${page}&search=${search}`);
        if(data.value){
            // globalStore.assignAlertMessage(data.value.message, 'success')
            appUsers.value = data.value as LoggedUser
            globalStore.toggleContentLoaderState('off')

        }else {
            console.log(error.value)
            globalStore.toggleContentLoaderState('off')

        }
    }
    // resend Verification
    async function resendEmailVerification(){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data,error} = await useApiFetch('/api/send-verification-email');
        if(data.value){
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(data.value.message, 'success');
        }
        else {
            globalStore.assignAlertMessage(error.value.message, 'error');

        }
        return {data,error}
    }
    // resend Verification
    async function userEmailVerification(verificationKey:string) : Promise{
        globalStore.toggleContentLoaderState('on')

        await useApiFetch("/sanctum/csrf-cookie");
        const verifyResponse = await useApiFetch(`/api/verify-user-email-${verificationKey}`);
        if(verifyResponse.status.value === 'success'){
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage(verifyResponse.data?.value.message, 'success');
        }
        else {
            globalStore.assignAlertMessage([[verifyResponse.error.value?.data?.message]], 'error');

        }
        globalStore.toggleContentLoaderState('off')
    }
    // Login
    async function login(credentials: Credential){
        await useApiFetch("/sanctum/csrf-cookie");
        const loginResponse = await useApiFetch('/login',{
            method: 'POST',
            body : credentials
        });
        if (loginResponse.status.value === 'success'){
            await fetchUser();
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage('Welcome back!!','success')
        if (user.value){
            navigateTo('/crm/');
        }
        }else {
            authErrors.value = loginResponse.error.value
            globalStore.toggleLoadingState('off')
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(authErrors.value?.data?.message, 'error')
        }
        return loginResponse;
    }
    //Logout
    async function logout(){
        const logout =  await useApiFetch('/logout', {method: 'POST'});
        if (logout.status.value === 'success'){
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage('You are logged out', 'warning')
            user.value = null;
            navigateTo('/')
            location.reload()
        }
    }
    //Register
    async function register(userInfo : RegistrationInfo){
        await useApiFetch("/sanctum/csrf-cookie");
        const registrationResponse = await useApiFetch("/register", {
            method: "POST",
            body: userInfo,
        });
        if(registrationResponse?.data.value?.code == 200){
            globalStore.toggleLoadingState('off')
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage('Registration Success: Check your Email','success')
            globalStore.toggleRegistrationForm()
        }else{
            authErrors.value = registrationResponse?.error.value?.data
            globalStore.toggleLoadingState('off')
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(authErrors.value?.message, 'error')
        }
        return registrationResponse;
    }
    async function saveUserInfo(userInfo : RegistrationInfo){
        await useApiFetch("/sanctum/csrf-cookie");
        const userInfoResponse = await useApiFetch("/api/user-info-create", {
            method: "POST",
            body: userInfo,
        });
        if(userInfoResponse.data.value?.code == 200){
            globalStore.toggleLoadingState('off')
            await fetchUser();
            globalStore.toggleUserInfoDialogStatus('off')   
            globalStore.assignAlertMessage(userInfoResponse.data.value?.message,'success')
        }if(userInfoResponse.data.value?.code == 300){
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(userInfoResponse.data.value?.message,'warning')
        }
        else{
            authErrors.value = userInfoResponse.error.value?.data
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(authErrors.value?.errors, 'error')
        }
        return userInfoResponse
    }
    async function sendPasswordResetLink(userEmail : string){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch("/api/send-password-reset-link", {
            method: "POST",
            body: userEmail,
        });
        if(data.value){
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage(data.value.message, 'success');
        }
        else {
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage([[error.value?.data?.message]], 'error');
        }
        return {data,error}
    }
    async function resetUserPassword(newUserPass : string){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch("/api/reset-password", {
            method: "POST",
            body: newUserPass,
        });
        if(data.value){
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage(data.value.message, 'success');
            navigateTo('/')
        }
        else {
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
        }
        return {data,error}
    }
    async function verifyProfessionalNumber(userRegNo : string){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch("/api/call/professional-details", {
            method: "POST",
            body: {'reg_number' :userRegNo},
        });
        if(data.value){
            globalStore.toggleLoadingState('off')
            professionalDetails.value = data.value?.data
            globalStore.assignAlertMessage(data.value.message, 'success');
        }
        else {
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage(error.value?.data?.message, 'error');
        }
    }

    // update user data
    async  function updateUserData (userKey: string , passedData : object): Promise {
        const  {data , error} = await  useApiFetch(`/api/admin-update-user-data/${userKey}`, {
            method:'post',
            body: passedData
        })
        if (data.value){
            globalStore.assignAlertMessage(data.value.message, 'success')
            console.log(data.value)
        }else{
            globalStore.assignAlertMessage(error.value.data?.message, 'warning')
        }
    }
    // update user Email
    async  function updateUseRole (userKey: string , roleId : string): Promise {
        const  {data , error} = await  useApiFetch(`/api/admin-update-user-role/${userKey}-${roleId}`)
        if (data.value){
            globalStore.assignAlertMessage(data.value.message, 'success')
            console.log(data.value)
        }else{
            globalStore.assignAlertMessage(error.value.data?.message, 'warning')
        }
    }
    return {
        user,login,isLoggedIn,getAuthErrors,saveUserInfo,
        logout,fetchUser,register,getLoggedUser,getUserRole
        ,getUserPermissions,getLoggedUserInfo,
        getAppUsers,retrieveAppUsers,
        resendEmailVerification,
        userEmailVerification,
        sendPasswordResetLink,resetUserPassword,
        verifyProfessionalNumber,
        getProfessionalDetails,
        updateUserData,
        updateUseRole
    }
})