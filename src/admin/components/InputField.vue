<template>
  <div class="w-full border group hover:border-sky-600 rounded px-2 py-1 mb-1 last:mb-0">
    <div class="flex w-full mb-2">
      <div class="grow">
        <p class="inline-block font-bold text-base text-sky-400">{{title}}</p> <span class="text-gray-500 select-all">{{fieldMeta.id}}</span>
      </div>
      <div class="actions hidden group-hover:flex">
        <font-awesome-icon class="my-auto cursor-pointer" :icon="['fas', 'trash-can']" @click="$emit('remove', index)"/>
      </div>
    </div>
    <div class="field-meta">
      <label for="label" class="">Label</label>
      <input class="" type="text" v-model.trim="fieldMeta.label" name="label" @change="changeCallback(fieldMeta)">
    </div>
    <div class="field-meta" v-show="fieldMeta.label !== ''">
      <label class="" for="decription">Desciption</label>
      <input class="" type="text" name="description" v-model.trim="fieldMeta.description" @change="changeCallback(fieldMeta)">
    </div>
    <div class="mb-1 last:mb-0" v-show="fieldMeta.label !== ''">
      <label class="w-1/6 inline-block after:content-[':']" for="required">Required</label>
      <input class="" type="checkbox" name="required" v-model="fieldMeta.required" @change="changeCallback(fieldMeta)">
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
        name: this.name,
      },
    }
  },
  computed: {
    name(){
      return slugify(this.label)
    }
  },
  mounted() {
    console.log(this.data)
    this.fieldMeta.label = this.data.label || ''
    this.fieldMeta.required = this.data.required || false
    this.fieldMeta.description = this.data.description || ''
    this.fieldMeta.id = this.data.id || Date.now()
  },

}
</script>

<style>

</style>
