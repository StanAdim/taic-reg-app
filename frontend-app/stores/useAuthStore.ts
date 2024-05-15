import type {Credential, LoggedUser, User} from "~/types/interfaces";

export const useAuthStore = defineStore('auth', ()=> {
    const  user = ref<User | null>(null)
    const isLoggedIn = computed(()=> !!user.value)
    const globalStore = useGlobalDataStore()
    const authErrors = ref()

    const getLoggedUser = computed(()=>{return user.value})
    const getAuthErrors = computed(()=>{return authErrors.value})
    //Fetch Logout
    async function fetchUser(){
        const {data,error} = await useApiFetch('/api/auth/user');
        if(data.value){
            globalStore.toggleLoadingState('off')
            user.value = data.value as LoggedUser
        }
        return {data,error}
    }
    // Login
    async function login(credentials: Credential){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch('/login',{
            method: 'POST',
            body : credentials
        });
        if (data.value){
            await fetchUser();
            globalStore.assignAlertMessage('Welcome back!!','success')
        if (user.value){ navigateTo('/crm/');}
        }else {
            authErrors.value = error.value?.data
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(authErrors.value?.errors, 'danger')
        }
        return {data, error};
    }
    //Logout
    async function logout(){
        const logout =  await useApiFetch('/logout', {method: 'POST'});
        user.value = null;
        navigateTo('/')
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
            globalStore.assignAlertMessage(authErrors.value?.errors, 'danger')
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
            globalStore.assignAlertMessage(userInfoResponse.data.value?.message,'success')
            globalStore.toggleUserInfoModal()
        }else{
            authErrors.value = userInfoResponse.error.value?.data
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(authErrors.value?.errors, 'danger')
        }
        return userInfoResponse
    }
    return {
        user,login,isLoggedIn,getAuthErrors,saveUserInfo,
        logout,fetchUser,register,getLoggedUser
    }
})