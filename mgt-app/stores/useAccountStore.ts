import type { ApiResponse } from "~/types/interfaces";

export const useAccountStore = defineStore('accountStore', () => {

    //Stores
    const accountUpdateDialogStatus= ref(false);
    const userInfoUpdateDialogStatus= ref(false);

    //Computed
    const getAccountUpdateDialogStatus = computed(() => {return accountUpdateDialogStatus.value})
    const getUserInfoUpdateDialogStatus = computed(() => {return userInfoUpdateDialogStatus.value})

    //Actions

    const toggleAccountDialogState = (key)=> (key == 'on') ? accountUpdateDialogStatus.value = true: accountUpdateDialogStatus.value = false
    const toggleUpdateUserInfoDialogState = (key)=> (key == 'on') ? userInfoUpdateDialogStatus.value = true: userInfoUpdateDialogStatus.value = false

    const handleUpdateAccount = async (passedData)=> {
        console.log(passedData)
    }
    const handleUserDetailUpdate = async (passedUserInfo)=> {
        console.log(passedUserInfo)
    }
    return {
        getAccountUpdateDialogStatus,getUserInfoUpdateDialogStatus,
        toggleAccountDialogState,
        toggleUpdateUserInfoDialogState,
        handleUpdateAccount,
        handleUserDetailUpdate,
    }
})