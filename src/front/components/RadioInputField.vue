<template>
  <component class="pry-radio-input" @fieldChange="onChange"
  :is="radioType" :fieldData="fieldData" :formId="formId" >
  </component>
  
</template>

<script>
import DefaultRadioInput from '@/front/components/DefaultRadioInputField.vue'
import SelectInput from '@/front/components/SelectInputField.vue'
import LabelInput from '@/front/components/LabelInputField.vue'
export default {
  name: 'RadioInput',
  components:{
    DefaultRadioInput,
    SelectInput,
    LabelInput,
  },
  computed: {
    radioType(){
      switch (this.fieldData.type) {
        case 'select':
          return 'SelectInput'
        case 'label':
          return 'LabelInput'
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
