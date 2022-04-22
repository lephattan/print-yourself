<template>
  <div>
    <label :for="name">{{fieldData.label}} <span class="text-red-600" v-if="required">*</span></label>
    <input type="text" :name="name" v-model="value" :required="required">
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
    }
  },
  data() {
    return {
      value: '',
      name: '',
      required: false
    }
  },
  mounted() {
    const rawName = this.fieldData.name || this.fieldData.label
    this.name = 'pry_cf-' + rawName
    this.required = this.fieldData.required || false
  },

}
</script>

<style>

</style>
