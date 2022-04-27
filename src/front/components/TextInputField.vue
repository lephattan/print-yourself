<template>
  <div>
    <label :for="name">
      {{fieldData.label}} 
      <span class="text-red-600" v-if="required">*</span>
      <span class="mx-1 text-red-700 font-bold" v-show="price > 0">+<currency-symbol />{{price}}</span>
    </label>
    <input type="text" :name="name" v-model="value" :required="required" v-if="id!==null" :id="id" @change="emitData('fieldChange')">
    <p class="text-sm" v-if="fieldData.description !== ''">{{fieldData.description}}</p>
  </div>
  
</template>

<script>
export default {
  name: 'TextInput',
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
      name: '',
      required: false,
      id: null,
      price: 0.0,
    }
  },
  mounted() {
    this.name = `_pry_cf-${this.formId}-${this.fieldData.id}`  
    this.required = this.fieldData.required || false
    this.id = this.fieldData.id || null
    this.price = parseFloat(this.fieldData.price || '0.0')
    this.emitData()
  },
  methods: {
    emitData(_event='fieldChange'){
      const data = {
        formId: this.formId,
        fieldId: this.fieldData.id,
        value: this.value,
        price: 0
      }
      if(this.value !== ''){
        data.price = parseFloat(this.price)
      }else{
        data.price = 0
      }
      this.$emit(_event, data)
    },
  },

}
</script>

<style>

</style>
