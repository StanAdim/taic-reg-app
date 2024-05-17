export const useLocalStorage = (initialValue:any, key:string) => {
  const val = ref(initialValue);
  onMounted(() => {
    const storageVal = localStorage.getItem(key);
 
    if (storageVal) {
      val.value = JSON.parse(storageVal);
    }
 
    watch(
      val,
      val => {
        localStorage.setItem(key, JSON.stringify(val));
      },
      {deep: true}
    );
  });
  return val
}
