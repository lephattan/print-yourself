<script setup>
  import Field from '@/admin/components/Field.vue'
</script>
<template>
  <div class="editor-wraper">
    <div class="grid w-full grid-cols-4 gap-1">
      <div class="p-1 col-span-3 box-border border w-full border-sky-500 border-dotted" @drop="onDrop($event)" @dragover.prevent @dragenter.prevent>
        <component v-for="field, i in editorFields" 
          :key="i" :is="field.type" :index="i" :field="field"
          @remove="fieldRemove"
        ></component>
        <div class="flex w-full h-full items-center" v-show="fields.length === 0">
          <p class="w-full text-center my-auto text-base text-gray-400/70">Drag a field from the right to this area</p>
        </div>
      </div>
      <div class="col-span-1 gap-1 box-border">
        <Field v-if="false" type="FieldGroup" @dragstart="startDrag($event, {type: 'FieldGroup'})"/>
        <Field type="TextInput" @dragstart="startDrag($event, {type: 'TextInput'})"/>
        <Field type="RadioInput" @dragstart="startDrag($event, {type: 'RaidoInput'})"/>
        <Field v-if="false" type="FileUpload" @dragstart="startDrag($event, {type: 'FileUpload'})"/>
      </div>
    </div>
  </div>
  
</template>

<script>
import {useEditorFields} from '@/admin/stores/editor'
import { mapState } from 'pinia'
import TextInput from '@/admin/components/TextInputField.vue'
import RadioInput from '@/admin/components/RadioInputField.vue'
export default {
  name: 'FormEditor',
  components:{ 
    TextInput,
    RadioInput,
  },
  computed:{
    editorJsonEl (){
      return document.getElementById('pry_fb-editor-json')
    },
    ...mapState(useEditorFields, {editorFields: 'editorFields'}),
  },
  data() {
    return {
      fields: [],
    }
  },
  mounted() {
    const editorJson = this.getEditorJson();
    if (null !== editorJson ){
      useEditorFields().loadFromJson(editorJson)
    } else {
      useEditorFields().loadFromJson([])
    }

    // Update editor json after a action is called
    useEditorFields().$onAction(({ name, store, args, after, onError }) => {
      after(() =>{
        this.updateEditorJson()
      })
    }, true
    )
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
      this.editorJsonEl.value = JSON.stringify(this.editorFields)
    },
    startDrag(evt){
      const dataType = evt.target.getAttribute('data-type')
      evt.dataTransfer.setData('dataType', dataType)
    },
    onDrop(evt){
      const dataType = evt.dataTransfer.getData('dataType')
      const fieldData = {
        type: dataType, 
        data: {
          label: '',
          required: false,
          description: '',
          id: Date.now(),
        },
      }
      useEditorFields().addField(fieldData)
      this.updateEditorJson();
    },
    fieldRemove(index){
      useEditorFields().removeField(index)
    },
  },

}
</script>

<style>

</style>
