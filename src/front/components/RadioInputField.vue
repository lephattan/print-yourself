<template>
  <component class="pry-radio-input" :is="radioType" :fieldData="fieldData" :formId="formId" @fieldChange="onChange">
  </component>
  
</template>

<script>
import DefaultRadioInput from '@/front/components/DefaultRadioInputField.vue'
export default {
  name: 'RadioInput',
  components:{
    DefaultRadioInput
  },
  computed: {
    radioType(){
      switch (this.fieldData.type) {
        case 'color':
          return 'ColorRadioInput'
          break;
        default:
          return 'DefaultRadioInput'
          break;
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
    }
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
