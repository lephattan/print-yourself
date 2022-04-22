<template>
  <div class="border border-sky-300 rounded px-2 py-1 flex mb-1 last:mb-0" draggable="true" :data-type="type" >
    <font-awesome-icon class="my-auto" :icon="icon" size='lg'/>
    <p class="text-center grow text-lg">{{text}}</p>
  </div>
  
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faLayerGroup, faFont, faUpload} from '@fortawesome/free-solid-svg-icons'
library.add([faLayerGroup, faFont, faUpload])

export default {
  name: 'Field',
  props: {
    type: {
      type: String
    }
  },
  data() {
    return {
      Fields: {
        FieldGroup:{
          text: 'Field Group',
          icon: [ 'fas', 'layer-group']
        },
        TextInput:{
          text: 'Text Input',
          icon: ['fas', 'font']
        },
        FileUpload: {
          text: 'File Upload',
          icon: ['fas', 'upload']
        },
      },
    }
  },
  computed:{
    text(){
      return this.Fields[this.type].text
    },
    icon(){
      return this.Fields[this.type].icon
    }
  },

}
</script>

<style>

</style>
