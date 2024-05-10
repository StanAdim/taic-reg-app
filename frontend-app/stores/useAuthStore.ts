
type User = {
    id:number,
    name: string,
    email:string,

}
type Credential = {
    email:string,
    password:string,
}
type LoggedUser ={
    id:number,
    name:string,
    token:string,
    email:string,
    email_verified_at:string,
    created_at:string,
    updated_at:string,
    message:string
}
type RegistrationInfo = {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}

export const useAuthStore = defineStore('auth', ()=> {
    const  user = ref<User | null>(null)
    const isLoggedIn = computed(()=> !!user.value)
    const globalStore = useGlobalDataStore()
    //Fetch Logout
    async function fetchUser(){
        const {data,error} = await useApiFetch('/api/auth/user');
        if(data.value){
            globalStore.setLoadingTo('off')
            user.value = data.value as LoggedUser

        }
        return {
            data,error
        }
    }
    // Login
    async function login(credentials: Credential){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch('/auth/login',{
            method: 'POST',
            body : credentials
        });
        await fetchUser();
        if (user.value){ navigateTo('/crm/dashboard');}
        return {data, error};
    }
    //Logout
    async function logout(){
        const logout =  await useApiFetch('/auth/logout', {method: 'POST'});
        user.value = null;
        navigateTo('/auth/login')
        return logout
    }
    //Register
    async function register(userInfo : RegistrationInfo){
        await useApiFetch("/sanctum/csrf-cookie");
        const register = await useApiFetch("/api/auth/register", {
            method: "POST",
            body: userInfo,
        });
        await fetchUser();
        return register;
    }
    return {
        user,login,isLoggedIn,logout,fetchUser,register
    }
})