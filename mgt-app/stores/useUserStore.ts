import type { ApiResponse } from "~/types/interfaces";

export const useUserStore = defineStore('userStore', () => {

    const globalStore = useGlobalDataStore()
    const systemUserDetail = ref([])

    const getSystemUserDetail = computed(() => {return systemUserDetail.value})

    async function retrieveSystemUserDetail(user_key:string){
        await useApiFetch("/sanctum/csrf-cookie");
        const {data, error} = await useApiFetch(`/api/system-user-${user_key}`);
        const response = data.value as ApiResponse
        if(response.code == 200){
            globalStore.toggleLoadingState('off')
            systemUserDetail.value = response.data
        }
        return {data, error};
    }
    return {
        retrieveSystemUserDetail,
        getSystemUserDetail,

    }
})