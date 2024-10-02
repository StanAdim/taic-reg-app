import type { ApiResponse } from "~/types/interfaces";
import {useApiFetch} from "~/composables/useApiFetch";

export const useFileExportsStore = defineStore('exportsStore', () => {

    const globalStore = useGlobalDataStore()
    const authStore = useAuthStore()
    const blobDataFile = ref(null)

// Function to initiate the download of users' Excel file
    const handleExcelFileExport = async (file_path, file_name , conference_id: string = ''): Promise<void> => {
        globalStore.toggleBtnLoadingState(true)
        const returned_file_path = ref('')
        console.log(conference_id);
        try {
            const { data, error } = await useApiFetch(`/api/export-report-${file_path}?name=${conference_id}`, {
                accept: "application/json",
            });
             returned_file_path.value = data.value?.path;
            globalStore.toggleBtnLoadingState(false)

            if (!returned_file_path.value) {
                throw new Error('File path not received');
            }
        } catch (error) {
            console.error('Error downloading file:', error);
        }
        if (returned_file_path.value !=''){
            await downloadStoredFile(returned_file_path.value, file_name);
        }else {
            console.log('No file path returned')
        }
    };

// Function to download a file given its path
    const downloadStoredFile = async (pass_path: string, file_name: string = "file") : Promise => {
        globalStore.toggleBtnLoadingState(true)
        const { data, error } = await useApiFetch(`/api/file-preview?name=${encodeURIComponent(pass_path)}`, {
            'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' // Set to Excel MIME type
        });
        if (data.value) {
            const blob = new Blob([data.value],
                { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' }); // Set blob type to Excel
            const url = URL.createObjectURL(blob);

            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', `${file_name}-file.xlsx`); // Change the file extension to .xlsx
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Clean up the URL object
            URL.revokeObjectURL(url);
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage('File Downloaded', 'success')
        }
        if (error.value) {
            console.log(error.value);
            globalStore.toggleBtnLoadingState(false)
            globalStore.assignAlertMessage(error.value?.message, 'error')
        }
    };

    return {
        handleExcelFileExport,

    }
})