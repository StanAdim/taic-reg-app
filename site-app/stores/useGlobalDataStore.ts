export const useGlobalDataStore = defineStore('glogalData', () => {

    const longName = ref('Tanzania Annual ICT Conference')
    const getAppLongName = computed(()=> longName.value)
      return {
          getAppLongName,

        }
    })