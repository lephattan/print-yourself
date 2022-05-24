<template>
  <component class="pry-radio-input" @fieldChange="onChange"
  :is="radioType" :fieldData="fieldData" :formId="formId" >
  </component>
  
</template>

<script>
import DefaultRadioInput from '@/front/components/DefaultRadioInputField.vue'
import SelectInput from '@/front/components/SelectInputField.vue'
export default {
  name: 'RadioInput',
  components:{
    DefaultRadioInput,
    SelectInput,
  },
  computed: {
    radioType(){
      switch (this.fieldData.type) {
        case 'select':
          return 'SelectInput'
        default:
          return 'DefaultRadioInput'
      }
    },
  },
  props: {
    fieldData:{
      type: Object,
      default: {}
    },
    formId: {
      type: String,
    },
  },
  mounted() {
  },
  methods: {
    onChange(data){
      //this.$emit('fieldChange', data)
    }
  },

}
</script>

<style>

</style>
