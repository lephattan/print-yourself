<template>
  <div class="label-radio">
    <label class="" :for="name">{{fieldData.label}}:
      <span class="text-red-600" v-if="fieldData.required">*</span>
      <span class="mx-1 text-slate-600"> {{value}}</span>
      <span class=" mx-1 text-red-700 font-bold" v-show="price > 0">+<currency-symbol />{{price}}</span>
    </label>
    <div class="flex gap-2 flex-wrap" v-show="false">
      <select v-model="value" @change="onChange" :name="name" :required="fieldData.required" :id="fieldData.id">
        <option v-if="fieldData.required !== true" value=""></option>
        <option v-for="(option, i) in fieldData.options" :key="i" :value="option.value">
        {{option.value}} <span v-if="option.price > 0" class="pry-select-option-price">(+<currency-symbol />{{option.price}})</span>
        </option>
      </select>
    </div>
    <div class="flex gap-2 flex-wrap">
      <div v-for="(option, i) in fieldData.options" :key="i"
        class="text-center cursor-pointer"
        @click="value=option.value;onChange()"
      >
        <div 
          class="border border-solid border-slate-400 hover:border-orange-400 rounded box-border px-2 h-[30px] w-[30px]"
          :class="{'border-orange-500 border-2':value==option.value}"
          :style="{ backgroundColor: option.colorHex, }"
          >
        </div>
        <p class="text-sm text-slate-500 w-full text-center">{{option.value}}</p>
      </div>
    </div>
    <p class="text-sm" v-if="fieldData.description !== ''">{{fieldData.description}}</p>
  </div>
  
</template>

<script>
export default {
  name: 'LabelInput',
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
    if(this.fieldData.required === true){
      this.value = this.fieldData.options[0].value
    }
    this.price = this.fieldData.options[0].price || 0
    this.emitData()
  },
  methods: {
    onChange(){
      const option = this.fieldData.options.filter(option => option.value == this.value)
      if (option.length > 0) {
        this.price = option[0].price
      } else {
        this.price = 0
      }
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
