import {error} from "vscode-jsonrpc/lib/common/is";

type User = {
    id:number,
    firstName: string,
    middleName: string,
    lastName: string,
    email:string,

}
type Credential = {
    email:string,
    password:string,
}
type LoggedUser ={
    id:number,
    firstName:string,
    middleName:string,
    lastName:string,
    token:string,
    email:string,
    email_verified_at:string,
    created_at:string,
    updated_at:string,
    message:string
}
type RegistrationInfo = {
    firstName: string;
    middleName: string;
    lastName: string;
    email: string;
    password: string;
    password_confirmation: string;
}

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
        return {
            data,error
        }
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
            globalStore.assignAlertMessage('Login Success','success')
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
    return {
        user,login,isLoggedIn,getAuthErrors,
        logout,fetchUser,register,getLoggedUser
    }
})