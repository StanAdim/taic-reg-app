import type { ApiResponse } from "~/types/interfaces";

export const useFileExportsStore = defineStore('exportsStore', () => {

    const globalStore = useGlobalDataStore()
    const blobDataFile = ref(null)

    const downloadUsersExcel = async () => {
        let headers: any = {
            accept: "application/json",
            responseType: 'arraybuffer',
            // Authorization: `Bearer ${authStore.getAccessToken}`,
        };
        try {
            // Make the request to download the file
            const response = await useApiFetch(`/api/export-users`, { ...headers });
            // Create a blob from the response data
            const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

            // Create a link element
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.setAttribute('download', 'system-users.xlsx'); // Set file name

            // Append link to the body
            document.body.appendChild(link);

            // Programmatically click the link to trigger the download
            link.click();

            // Remove the link after download
            document.body.removeChild(link);
        } catch (error) {
            console.error('Error downloading the file', error);
        }
    }


    return {
        downloadUsersExcel,

    }
})