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
      <input type="text" v-model="label" name="label" @change="onChange">
    </div>
    <div>
      <label for="decription">Desciption:</label>
      <input type="text" name="desciption" v-model="desciption" @change="onChange">
    </div>

  </div>
  
</template>

<script>
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
      desciption: ''
    }
  },
  mounted() {
    this.label = this.data.label || ''
    this.required = this.data.required || false
    this.desciption = this.data.desciption || ''
  },
  methods: {
    onChange(){
      const data = {
        label: this.label,
        required: this.required,
        desciption: this.desciption
      }
      this.$emit('update', {'index': this.index, data})
    }
  },

}
</script>

<style>

</style>
