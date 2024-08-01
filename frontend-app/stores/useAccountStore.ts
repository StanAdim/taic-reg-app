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
        const registrationResponse = await useApiFetch(`/user/${type}-update`, {
            method: "POST",
            body: userInfo,
        });
        if(registrationResponse?.data.value?.code == 200){
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage('Account updated Success','success')
            toggleAccountDialogState('off');
        }else{
            authErrors.value = registrationResponse?.error.value?.data
            globalStore.toggleLoadingState('off')
            globalStore.assignAlertMessage(authErrors.value?.message, 'error')
        }
         await authStore.fetchUser()
        return registrationResponse;
    }

    return {
        getAccountUpdateDialogStatus,getUserInfoUpdateDialogStatus,
        toggleAccountDialogState,
        toggleUpdateUserInfoDialogState,
        handleUserAccountUpdate,
    }
})