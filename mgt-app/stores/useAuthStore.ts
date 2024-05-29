import type {Credential, LoggedUser, User} from "~/types/interfaces";
import {defineStore} from "pinia";
import {useApiFetch} from "~/composables/useApiFetch";
export const useAuthStore = defineStore('auth', ()=> {
    const  user = ref<User | null>(null)
    const isLoggedIn = computed(()=> !!user.value)
    const globalStore = useGlobalDataStore()
    const authErrors = ref <any | null>(null)
    const appUsers = ref <any>([])

    const getLoggedUser = computed(()=>{return user.value?.user})
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
        return {data,error}
    }
    //Fetch Application Users
    async function retrieveAppUsers(){
        const {data,error} = await useApiFetch('/api/application-users');
        if(data.value){
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(data.value.message, 'success')
            appUsers.value = data.value as LoggedUser
        }
        return {data,error}
    }
    // resend Verification
    async function resendEmailVerification(){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data,error} = await useApiFetch('/api/send-verification-email');
        if(data.value){
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(data.value.message, 'success');
        }
        return {data,error}
    }
    // resend Verification
    async function userEmailVerification(verificationKey:string){
        await useApiFetch("/sanctum/csrf-cookie");
        const verifyResponse = await useApiFetch(`/api/verify-user-email-${verificationKey}`);
        if(verifyResponse.status.value === 'success'){
            globalStore.toggleLocalLoaderStatus()
            globalStore.assignAlertMessage(verifyResponse.data.value.message, 'success');
        }
        return verifyResponse
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
            globalStore.assignAlertMessage('Welcome back!!','success')
        if (user.value){
            navigateTo('/crm/');
        }
        }else {
            authErrors.value = loginResponse.error.value
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage([[authErrors.value?.data?.message]], 'danger')
        }
        return loginResponse;
    }
    //Logout
    async function logout(){
        const logout =  await useApiFetch('/logout', {method: 'POST'});
        if (logout.status.value === 'success'){
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage([['You are logged out']], 'danger')
            user.value = null;
            navigateTo('/')
        }
        return logout
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
            globalStore.assignAlertMessage('Registration Success: Check your Email','success')
            globalStore.toggleRegistrationForm()
        }else{
            authErrors.value = registrationResponse?.error.value?.data
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage([[authErrors.value?.message]], 'danger')
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
        }else{
            authErrors.value = userInfoResponse.error.value?.data
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(authErrors.value?.errors, 'danger')
        }
        return userInfoResponse
    }
    return {
        user,login,isLoggedIn,getAuthErrors,saveUserInfo,
        logout,fetchUser,register,getLoggedUser,getUserRole
        ,getUserPermissions,getLoggedUserInfo,
        getAppUsers,retrieveAppUsers,
        resendEmailVerification,
        userEmailVerification
    }
})