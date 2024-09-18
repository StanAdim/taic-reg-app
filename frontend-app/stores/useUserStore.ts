import type { ApiResponse } from "~/types/interfaces";

export const useUserStore = defineStore('userStore', () => {

    const globalStore = useGlobalDataStore()
    const systemUserDetail = ref(null)

    const getSystemUserDetail = computed(() => {return systemUserDetail.value})

    async function retrieveSystemUserDetail(user_key:string){
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/system-user-${user_key}`);
        if(data.value){
            systemUserDetail.value = data.value?.data
        }else {
            console.log(error.value)
        }
        globalStore.toggleContentLoaderState('off')
    }

    return {
        retrieveSystemUserDetail,
        getSystemUserDetail,

    }
})