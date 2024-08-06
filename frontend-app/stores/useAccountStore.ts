import type { ApiResponse } from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

export const useAccountStore = defineStore('accountStore', () => {
    const globalStore = useGlobalDataStore()
    const authStore = useAuthStore()

    //Stores
    const accountUpdateDialogStatus= ref(false);
    const userInfoUpdateDialogStatus= ref(false);

    //Computed
    const getAccountUpdateDialogStatus = computed(() => {return accountUpdateDialogStatus.value})
    const getUserInfoUpdateDialogStatus = computed(() => {return userInfoUpdateDialogStatus.value})

    //Actions

    const toggleAccountDialogState = (key)=> (key == 'on') ? accountUpdateDialogStatus.value = true: accountUpdateDialogStatus.value = false
    const toggleUpdateUserInfoDialogState = (key)=> (key == 'on') ? userInfoUpdateDialogStatus.value = true: userInfoUpdateDialogStatus.value = false

    async function handleUserAccountUpdate(userInfo : RegistrationInfo, type : string){
        const {data , error} = await useApiFetch(`/user/${type}-update`, {
            method: "POST",
            body: userInfo,
        });
        console.log(data.value)
        if(data.value?.code === 200){
             await authStore.fetchUser()
            toggleUpdateUserInfoDialogState('off')
            globalStore.assignAlertMessage('Account updated Success','success')
        }
        if (error.value){
            globalStore.assignAlertMessage(error.value?.message, 'error')
        }
        toggleAccountDialogState('off');
    }

    return {
        getAccountUpdateDialogStatus,getUserInfoUpdateDialogStatus,
        toggleAccountDialogState,
        toggleUpdateUserInfoDialogState,
        handleUserAccountUpdate,
    }
})