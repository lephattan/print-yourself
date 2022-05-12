<template>
  <div class="w-full border group hover:border-sky-600 rounded px-2 py-1 mb-1 last:mb-0">
    <div class="flex w-full mb-2">
      <div class="grow">
        <p class="inline-block my-1 font-bold text-base text-sky-400 mr-2">{{title}}</p> 
        <span class="text-gray-500 select-all mr-2">{{field.data.id}}</span>
        <span class="text-gray-500 select-all mr-2">_pry-cf_{{name}}</span>
      </div>
      <div class="actions hidden group-hover:flex">
        <font-awesome-icon class="p-2 cursor-pointer hover:ring-1 ring-inset hover:ring-slate-400 hover:rounded" :icon="['fas', 'angle-up']" @click="moveField(index, index-1)"/>
        <font-awesome-icon class="p-2 cursor-pointer hover:ring-1 ring-inset hover:ring-slate-400 hover:rounded" :icon="['fas', 'angle-down']" @click="moveField(index, index+1)"/>
        <font-awesome-icon class="pl-2 my-auto cursor-pointer" :icon="['fas', 'trash-can']" @click="$emit('remove', index)"/>
      </div>
    </div>
    <div class="field-meta">
      <label for="label" class="">Label</label>
      <input class="" type="text" v-model.trim="field.data.label" name="label" @change="onChange">
    </div>
    <div class="field-meta" v-show="field.label !== ''">
      <label class="" for="decription">Desciption</label>
      <input class="" type="text" name="description" v-model.trim="field.data.description" @change="onChange">
    </div>
    <div class="mb-1 last:mb-0" v-show="field.label !== ''">
      <label class="w-1/6 inline-block after:content-[':']" for="required">Required</label>
      <input class="" type="checkbox" name="required" v-model="field.data.required" @change="onChange">
    </div>
    <slot></slot>
  </div>
  
</template>

<script>
import {useEditorFields} from '@/admin/stores/editor'
import { mapState } from 'pinia'
import { library } from '@fortawesome/fontawesome-svg-core'
import {faTrashCan, faAngleUp, faAngleDown} from '@fortawesome/free-solid-svg-icons'
library.add([faTrashCan, faAngleDown, faAngleUp])
import {slugify} from '@/helper.js'
export default {
  name: 'InputField',
  props:{
    index:{
      type: Number
    },
    title:{
      type: String,
      default: '',
    },
    field: {},
  },
  data() {
    return {}
  },
  computed: {
    name(){
      if (this.field.data.label !== undefined ){
        return slugify(this.field.data.label)
      } else{
        return ''
      }
    },
    ...mapState(useEditorFields, {editorFields: 'editorFields'}),
  },
  methods: {
    onChange(){
      useEditorFields().onUpdate()
    },
    moveField(from, to){
      useEditorFields().moveField(from, to)
    }
  },

}
</script>

<style>
.field-meta{
  @apply mb-1 last:mb-0;
}
.field-meta > label{
  @apply w-1/6 inline-block after:content-[':']
}
.field-meta > input {
  @apply w-5/6;
}

</style>
