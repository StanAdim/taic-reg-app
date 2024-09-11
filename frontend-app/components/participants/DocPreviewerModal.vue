<script setup lang="ts">
const docStore = useDocumentMaterialStore()
const props = defineProps({
  title: {
    type:String,
    default: 'Document Previewer'
  },
  mode: {
    type: Boolean
  }
  ,
  blobDataFile: () => {

  }

})

// const  modalStatus = ref(true)
const  close = () => {
  docStore.togglePreviewModalStatus(false)
}

</script>

<template>
  <div class="">
    <el-dialog :before-close="close" v-model="props.mode" :title="props.title" width="88%" center>
      <div class="bg-white">
        <div class="">
          <div>
            <div class="mt-[10px]">
              <div class="">
                <iframe
                    v-if="props.blobDataFile"
                    :src="props.blobDataFile"
                    width="100%"
                    height="600px"
                ></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>

      <template #footer>
        <div class="dialog-footer">
          <el-button type="info" @click="close">Cancel</el-button>
        </div>
      </template>
    </el-dialog>
  </div>

</template>

<style scoped>

</style>