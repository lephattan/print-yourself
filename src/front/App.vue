<template>
  <div class="w-full pry-main">
    <div v-for="(formFields, formId ) in forms" :key='formId' :class="['pry-form', 'pry-form_'+formId.toString()]">
      <component v-for="field, i in formFields" :is="field.type" :formId="formId" :fieldData="field.data" :key="i" class="pry-field"></component>
    </div>

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
      forms : {}
      
    }
  },
  mounted() {
    this.forms = window.plData || {}
  },
  methods: {
    
  },
}
</script>
<style>

</style>
