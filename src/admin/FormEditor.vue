<script setup>
  import Field from '@/admin/components/Field.vue'
</script>
<template>
  <div class="editor-wraper">
    <div class="grid w-full grid-cols-4 gap-1">
      <div class="p-1 col-span-3 border w-full border-sky-500 border-dotted" @drop="onDrop($event)" @dragover.prevent @dragenter.prevent>
        <component v-for="field, i in fields" :is="field.type" :index="i" @update="fieldUpdate" :data="field.data" @remove="fieldRemove"></component>
        <div class="flex w-full h-full items-center" v-show="fields.length === 0">
          <p class="w-full text-center my-auto text-base text-gray-400/70">Drag a field from the right to this area</p>
        </div>
      </div>
      <div class="col-span-1 gap-1">
        <Field type="FieldGroup" @dragstart="startDrag($event, {type: 'FieldGroup'})"/>
        <Field type="TextInput" @dragstart="startDrag($event, {type: 'TextInput'})"/>
        <Field type="FileUpload" @dragstart="startDrag($event, {type: 'FileUpload'})"/>
      </div>
    </div>
  </div>
  
</template>

<script>
import TextInput from '@/admin/components/TextInputField.vue'
export default {
  name: 'FormEditor',
  components:{ 
    TextInput,
  },
  computed:{
    editorJsonEl (){
      return document.getElementById('pry_fb-editor-json')
    },
  },
  data() {
    return {
      fields: [],
    }
  },
  mounted() {
    const editorJson = this.getEditorJson();
    if (null !== editorJson ){
      this.fields = editorJson
    } else {
      this.fields = []
    }
    console.log(this.fields)
  },
  methods: {
    getEditorJson(){
      const el = document.getElementById('pry_fb-editor-json')
      try {
        return JSON.parse(el.value)
      } catch (error) {
        console.log('Error getting editor json', error)
        return null
      }
    },
    updateEditorJson(){
      this.editorJsonEl.value = JSON.stringify(this.fields)
    },
    startDrag(evt){
      const dataType = evt.target.getAttribute('data-type')
      evt.dataTransfer.setData('dataType', dataType)
    },
    onDrop(evt){
      const dataType = evt.dataTransfer.getData('dataType')
      this.fields.push({type: dataType, data: {}})
      console.log(this.fields)
      this.updateEditorJson();
    },
    fieldUpdate(data){
      console.log(data)
      this.fields[data.index].data = data.data
      this.updateEditorJson()
    },
    fieldRemove(index){
      this.fields.splice(index, 1)
      this.updateEditorJson()
    }
    
  },

}
</script>

<style>

</style>
