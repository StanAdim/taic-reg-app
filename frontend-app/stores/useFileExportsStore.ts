import type { ApiResponse } from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

export const useFileExportsStore = defineStore('exportsStore', () => {

    const globalStore = useGlobalDataStore()
    const authStore = useAuthStore()
    const blobDataFile = ref(null)

// Function to initiate the download of users' Excel file
    const downloadUsersExcel = async (): Promise<void> => {
        const filePath = ref('')
        try {
            const { data, error } = await useApiFetch(`/api/export-test`, {
                accept: "application/json",
            });
             filePath.value = data.value?.path;
            if (!filePath.value) {
                throw new Error('File path not received');
            }
            console.log(filePath.value);
        } catch (error) {
            console.error('Error downloading file:', error);
        }
        await downloadFile(filePath.value);
    };

// Function to download a file given its path
    const downloadFile = async (filePath: string): Promise<void> => {
        const headers = {
            responseType: 'blob',
            // Authorization: `Bearer ${auth.getAccessToken}`,
        };

        try {
            const { data, error } = await useApiFetch(`/api/file-preview?name=${encodeURIComponent(filePath)}`, { ...headers });
                let fileName = 'excel.xlsx'
            // Create a link element
            const url = window.URL.createObjectURL(new Blob([data]));
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', fileName); // Specify the file name

            // Append to the body and trigger download
            document.body.appendChild(link);
            link.click();

            // Clean up and remove the link
            link.parentNode.removeChild(link);
        } catch (error) {
            console.error('Error downloading the file', error);
        }
    };
    return {
        downloadUsersExcel,

    }
})