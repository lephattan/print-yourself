<template>
  <div class="border border-solid border-sky-300 rounded px-2 py-1 flex mb-1 last:mb-0" draggable="true" :data-type="type" >
    <font-awesome-icon class="my-auto" :icon="icon" size='lg'/>
    <p class="text-center grow text-lg my-0">{{text}}</p>
  </div>
  
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faLayerGroup, faFont, faUpload, faCircleDot } from '@fortawesome/free-solid-svg-icons'
library.add([faLayerGroup, faFont, faUpload, faCircleDot ])

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
        RadioInput: {
          text: 'Radio',
          icon: ['fas', 'circle-dot'],
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
