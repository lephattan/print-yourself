<template>
  <div class="w-full pry-main">
    <component v-for="field, i in fields" :is="field.type" :fieldData="field.data" :key="i"></component>

  </div>
</template>
<script>
import TextInput from '@/front/components/TextInputField.vue'
export default {
  name: 'ProductApp',
  components: {
    TextInput,
  },
  data() {
    return {
      fields : []
      
    }
  },
  mounted() {
    this.fields = window.plData || []
    console.log(this.fields)
    
  },
  methods: {
    
  },
}
</script>
<style>

</style>
