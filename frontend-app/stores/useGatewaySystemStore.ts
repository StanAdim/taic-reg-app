import type { ApiResponse } from "~/types/interfaces";

export const useGatewaySystemStore = defineStore('systemStore', () => {

    const globalStore = useGlobalDataStore()
    const registeredSystems = ref(null)

    const getRegisteredSystems = computed(() => {return registeredSystems.value})

    async function retrieveRegisteredSystems(user_key:string) : Promise{
        globalStore.toggleContentLoaderState('on')
        const {data, error} = await useApiFetch(`/api/gateway/registered-system`);
        if(data.value){
            registeredSystems.value = data.value?.data
            globalStore.toggleContentLoaderState('off')

        }else {
            console.log(error.value)
            globalStore.toggleContentLoaderState('off')

        }
    }
    return {
        retrieveRegisteredSystems,
        getRegisteredSystems,

    }
})