<template>
  <div class="w-full border group hover:border-sky-600 rounded px-2 py-1 mb-1 last:mb-0">
    <div class="flex w-full">
      <p class="grow font-bold text-base text-sky-400">Text Input</p>
      <div class="actions hidden group-hover:flex">
        <font-awesome-icon class="my-auto cursor-pointer" :icon="['fas', 'trash-can']" @click="$emit('remove', index)"/>
      </div>
    </div>
    <div class="mb-1">
      <label for="label">Label: </label>
      <input type="text" v-model.trim="label" name="label" @change="onChange">
    </div>
    <div>
      <label for="decription">Desciption:</label>
      <input type="text" name="description" v-model.trim="description" @change="onChange">
    </div>
    <div>
      <label for="required">Required:</label>
      <input type="checkbox" name="required" v-model="required" @change="onChange">
    </div>

  </div>
  
</template>

<script>
import {slugify} from '@/helper.js'
import { library } from '@fortawesome/fontawesome-svg-core'
import {faTrashCan} from '@fortawesome/free-solid-svg-icons'
library.add([faTrashCan])
export default {
  name: 'TextInput',
  props:{
    index:{
      type: Number
    },
    data:{
      type: Object,
      default: {}
    }
  },
  data() {
    return {
      label: '',
      required: false,
      description: ''
    }
  },
  computed: {
    name(){
      return slugify(this.label)
    }
  },
  mounted() {
    this.label = this.data.label || ''
    this.required = this.data.required || false
    this.description = this.data.description || ''
  },
  methods: {
    onChange(){
      const data = {
        label: this.label,
        required: this.required,
        description: this.description,
        name: this.name,
      }
      this.$emit('update', {'index': this.index, data})
    }
  },

}
</script>

<style>

</style>
