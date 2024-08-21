import type { ApiResponse } from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

export const useRoleStore = defineStore('roleStore', () => {
    const globalStore = useGlobalDataStore()

    //Stores
    const systemRoles= ref([]);
    const systemPermissions= ref([]);

    //Computed
    const getSystemRoles = computed(() => {return systemRoles.value})
    const getSystemPermissions = computed(() => {return systemPermissions.value})

    //Actions
    async function retrieveSystemRoles() {
        const { data, error } = await useApiFetch(`/api/booth-request`);
        if(data.value){
            systemRoles.value = data.value?.data;
        }
        else {
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
        }
    }
    async function retrieveSystemPermissions() {
        const { data, error } = await useApiFetch(`/api/booth-request`);
        if(data.value){
            systemPermissions.value = data.value?.data;
        }
        else {
            globalStore.assignAlertMessage(error.value?.data?.message, 'error')
        }
    }



    return {
        getSystemPermissions,getSystemRoles,
        retrieveSystemRoles,
        retrieveSystemPermissions,
    }
})