<template>
  <div class="w-full border group hover:border-sky-600 rounded px-2 py-1 mb-1 last:mb-0">
    <div class="flex w-full mb-2">
      <div class="grow">
        <p class="inline-block font-bold text-base text-sky-400 mr-2">{{title}}</p> 
        <span class="text-gray-500 select-all mr-2">{{fieldMeta.id}}</span>
        <span class="text-gray-500 select-all mr-2">_pry-cf_{{name}}</span>
      </div>
      <div class="actions hidden group-hover:flex">
        <font-awesome-icon class="my-auto cursor-pointer" :icon="['fas', 'trash-can']" @click="$emit('remove', index)"/>
      </div>
    </div>
    <div class="field-meta">
      <label for="label" class="">Label</label>
      <input class="" type="text" v-model.trim="fieldMeta.label" name="label" @change="onChange">
    </div>
    <div class="field-meta" v-show="fieldMeta.label !== ''">
      <label class="" for="decription">Desciption</label>
      <input class="" type="text" name="description" v-model.trim="fieldMeta.description" @change="onChange">
    </div>
    <div class="mb-1 last:mb-0" v-show="fieldMeta.label !== ''">
      <label class="w-1/6 inline-block after:content-[':']" for="required">Required</label>
      <input class="" type="checkbox" name="required" v-model="fieldMeta.required" @change="onChange">
    </div>
    <slot></slot>
  </div>
  
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import {faTrashCan} from '@fortawesome/free-solid-svg-icons'
import {slugify} from '@/helper.js'
library.add([faTrashCan])
export default {
  name: 'InputField',
  props:{
    index:{
      type: Number
    },
    data:{
      type: Object,
      default: {}
    },
    title:{
      type: String,
      default: '',
    },
    changeCallback:{
    },
  },
  data() {
    return {
      fieldMeta:{
        label: '',
        required: false,
        description: '',
        id: '',
      },
    }
  },
  computed: {
    name(){
      return slugify(this.fieldMeta.label)
    }
  },
  mounted() {
    this.fieldMeta.label = this.data.label || ''
    this.fieldMeta.required = this.data.required || false
    this.fieldMeta.description = this.data.description || ''
    this.fieldMeta.id = this.data.id || Date.now()
  },
  methods: {
    onChange(){
      this.changeCallback({...this.fieldMeta, name: this.name, index:this.index})
    },
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
