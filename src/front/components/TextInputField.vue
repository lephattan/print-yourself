<template>
  <div>
    <label :for="name">{{fieldData.label}} <span class="text-red-600" v-if="required">*</span></label>
    <input type="text" :name="name" v-model="value" :required="required" v-if="id!==null" :id="id">
    <p>{{fieldData.description}}</p>
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
    }
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
    this.name = `pry_cf-${this.formId}-${this.fieldData.id}`  
    this.required = this.fieldData.required || false
    this.id = this.fieldData.id || null
    this.price = parseFloat(this.fieldData.price || '0.0')
  },

}
</script>

<style>

</style>
