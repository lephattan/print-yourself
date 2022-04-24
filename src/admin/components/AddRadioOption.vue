<template>
  <div class="border-sky-300 border rounded p-2">
    <p class="text-slate-400 font-bold">Add option to Radio Group</p>
    <div class="w-full grid grid-cols-6 gap-1 items-center">
        <label class="col-span-1" for="radio-label">Value</label>
        <input class="col-span-5" type="text" v-model="value" name="radio-value">
        <label for="radio-price">Price</label>
        <input type="number" v-model="price" name="radio-price">
      <div class="row col-span-6 grid grid-cols-6 items-center" v-if="radioType === 'color'">
        <label class="col-span-1" for="radio-color">Color</label>
        <input type="text" v-model="colorHex" name="radio-color">
      </div>
      <div class="row col-span-6 grid grid-cols-6 items-center" v-if="radioType === 'image'">
        <label class="col-span-1" for="radio-image">Image</label>
        <input type="text" v-model="image" name="radio-image">
      </div>
      
    </div>
    
    <div class="flex gap-2 p-2">
      <button class="rounded border p-2 border-gray-300 hover:bg-gray-300" type="button" @click="add">Add</button>
      <button class="rounded border p-2 border-gray-300 hover:bg-gray-300" type="button" @click="clear">Clear</button>
    </div>
  </div>
  
</template>

<script>
export default {
  name: 'AddRadioOption',
  props:{
    radioType: {
      type: String,
      default: 'default'
    },
  },
  data() {
    return {
      value: '',
      price: 0.0,
      colorHex: null,
      image: null,
    }
  },
  methods: {
    clear(){
      this.value = ''
      this.price = 0.0 
      this.colorHex = null
      this.image = null
    },
    add(){
      if (this.value !== ''){
        this.$emit('addOption', {
          value: this.value,
          price: this.price,
          colorHex: this.colorHex,
          image: this.image,
        })
        this.clear()
        console.log(this.value)
      }
    },
  },

}
</script>

<style>

</style>
