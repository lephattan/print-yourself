<template>
  <div class="default-radio">
    <label class="" :for="name">{{fieldData.label}}:
      <span class="text-red-600" v-if="fieldData.required">*</span>
      <span class="mx-1 text-slate-600"> {{value}}</span>
      <span class=" mx-1 text-red-700 font-bold" v-show="price !== 0">+<currency-symbol />{{price}}</span>
    </label>
    <div class="flex gap-2 flex-wrap">
      <label class="block border-solid text-center border rounded border-slate-300 px-1" :for="name+'-'+i.toString()" 
        v-for="(option, i) in fieldData.options" :key="i">
        <input class="mx-2.5 mb-0" :id="name+'-'+i.toString()" type="radio" :name="name" :value="option.value" :required="option.required" v-model="value" @change="onChange(option.value, option.price)">
        <span class="block">{{option.value}}</span>
        <span class="text-red-700" v-if="option.price !== 0 && option.price > 0">${{option.price}}</span>
      </label>
    </div>
    <p class="text-sm" v-if="fieldData.description !== ''">{{fieldData.description}}</p>
  </div>
  
</template>

<script>
export default {
  name: 'DefaultRadioInput',
  props: {
    fieldData:{
      type: Object,
      default: {}
    },
    formId: {
      type: String,
    },
  },
  data() {
    return {
      value: '',
      price: 0
    }
  },
  computed: {
    name(){
      return `_pry_cf-${this.formId}-${this.fieldData.id}`
    }
  },
  mounted() {
    this.value = this.fieldData.options[0].value || ''
    this.price = this.fieldData.options[0].price || 0
    this.emitData()
  },
  methods: {
    onChange(value, price){
      this.price = price
      this.emitData()
    },
    emitData(_event='fieldChange'){
      const data = {
        formId: this.formId,
        fieldId: this.fieldData.id,
        value: this.value,
        price: this.price
      }
      this.$emit(_event, data)
    },
  },

}
</script>

<style>

</style>
