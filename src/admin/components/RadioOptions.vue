<template>
  <div>
    <div class="rounded border border-slate-400 hover:border-sky-600 p-1 mb-1 last:mb-0" v-for="(option, index) in options" :key="index">
      <div class="w-full grid grid-cols-6 gap-1 items-center">
          <label class="col-span-1" :for="'radio-label-'+index.toString()">Value</label>
          <input @change="updateOptions" class="col-span-5" type="text" v-model="option.value" :name="'radio-value-'+index.toString()">
          <label :for="'radio-price-'+index.toString()">Price</label>
          <input @change="updateOptions" type="number" v-model="option.price" :name="'radio-price-'+index.toString()">
        <div class="row col-span-6 grid grid-cols-6 items-center" v-if="radioType === 'color'">
          <label class="col-span-1" :for="'radio-color-'+index.toString()">Color</label>
          <input @change="updateOptions" type="text" v-model="option.colorHex" :name="'radio-color-'+index.toString()">
        </div>
        <div class="row col-span-6 grid grid-cols-6 items-center" v-if="radioType === 'image'">
          <label class="col-span-1" :for="'radio-image-'+index.toString()">Image</label>
          <input @change="updateOptions" type="text" v-model="option.image" :name="'radio-image-'+index.toString()">
        </div>
      </div>
      <div class="actions flex gap-2 py-1 px-2">
        <font-awesome-icon class="p-2 cursor-pointer mr-3 ring-inset hover:ring hover:ring-slate-400 hover:rounded" :icon="['fas', 'trash-can']" @click="removeOption(index)"/>
        <font-awesome-icon class="p-2 cursor-pointer ring-inset hover:ring hover:ring-slate-400 hover:rounded" :icon="['fas', 'angle-up']" @click="moveOption(index, index-1)"/>
        <font-awesome-icon class="p-2 cursor-pointer ring-inset hover:ring hover:ring-slate-400 hover:rounded" :icon="['fas', 'angle-down']" @click="moveOption(index, index+1)"/>
      </div>
    </div>
  </div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import {faTrashCan, faAngleUp, faAngleDown} from '@fortawesome/free-solid-svg-icons'
library.add([faTrashCan, faAngleDown, faAngleUp])
export default {
  name: 'RadioOptions',
  props:{
    options: {
      type: Array,
      default: []
    },
    radioType: {
      type: String,
      default: 'default'
    },
  },
  data() {
    return {
      
    }
  },
  mounted() {
  },
  methods: {
    updateOptions(){
      this.$emit('updateOptions', this.options)
    },
    removeOption(index){
      this.options.splice(index, 1)
        this.updateOptions()
    },
    moveOption(from, to){
      if(to <0 || to > (this.options.length - 1) ){
        return
      } else {
        [this.options[to], this.options[from]] = [this.options[from], this.options[to]]
        this.updateOptions()
      }
    }
  },

}
</script>

<style>

</style>
