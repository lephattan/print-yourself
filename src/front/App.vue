<template>
  <div class="w-full pry-main">
    <div v-for="(formFields, formId ) in forms" :key='formId' :class="['pry-form', 'pry-form_'+formId.toString()]">
      <component @fieldChange="onFieldChange" v-for="field, i in formFields" :is="field.type" :formId="formId" :fieldData="field.data" :key="i" class="pry-field"></component>
    </div>
    <p v-show="totalFee > 0" class="font-bold text-lg text-slate-700">Customization fee: <span class="text-red-500 text-2xl">${{totalFee}}</span></p>

  </div>
</template>
<script>
import TextInput from '@/front/components/TextInputField.vue'
import RadioInput from '@/front/components/RadioInputField.vue'
export default {
  name: 'ProductApp',
  components: {
    TextInput,
    RadioInput,
  },
  data() {
    return {
      forms : {},
      values: {}
    }
  },
  computed: {
    totalFee(){
      return Object.values(this.values).reduce( 
        (a, b)=> {return a + b.price}, 
        0)
    }
  },
  mounted() {
    this.forms = window.plData || {}
  },
  methods: {
    onFieldChange(fieldData){
      this.values[`${fieldData.formId}-${fieldData.fieldId}`] = {
        price: fieldData.price || 0,
        value: fieldData.value
      }
    },
    
  },
}
</script>
<style>

</style>
