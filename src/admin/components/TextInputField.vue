<template>
  <div class="w-full border group hover:border-sky-600 rounded px-2 py-1 mb-1 last:mb-0">
    <div class="flex w-full">
      <p class="grow font-bold text-base text-sky-400">Text Input</p>
      <div class="actions hidden group-hover:flex">
        <font-awesome-icon class="my-auto cursor-pointer" :icon="['fas', 'trash-can']" @click="$emit('remove', index)"/>
      </div>
    </div>
    <div class="mb-1 last:mb-0">
      <label for="label" class="w-1/6 inline-block after:content-[':']">Label</label>
      <input class="w-5/6" type="text" v-model.trim="label" name="label" @change="onChange">
    </div>
    <div class="mb-1 last:mb-0" v-show="label !== ''">
      <label class="w-1/6 inline-block after:content-[':']" for="decription">Desciption</label>
      <input class="w-5/6" type="text" name="description" v-model.trim="description" @change="onChange">
    </div>
    <div class="mb-1 last:mb-0" v-show="label !== ''">
      <label class="w-1/6 inline-block after:content-[':']" for="required">Required</label>
      <input class="w-5/6" type="checkbox" name="required" v-model="required" @change="onChange">
    </div>
    <div class="mb-1 last:mb-0" v-show="label !== ''">
      <label class="w-1/6 inline-block after:content-[':']" for="price">Price</label>
      <input class="w-5/6" type="number" name="pirce" v-model.trim="price" @change="onChange">
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
      description: '',
      id: '',
      price: '',
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
    this.id = this.data.id || Date.now()
    this.price = this.data.price || ''
  },
  methods: {
    onChange(){
      const data = {
        label: this.label,
        required: this.required,
        description: this.description,
        name: this.name,
        id: this.id,
        price: this.price,
      }
      this.$emit('update', {'index': this.index, data})
    }
  },

}
</script>

<style>

</style>
