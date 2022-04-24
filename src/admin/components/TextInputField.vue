<template>
  <InputField :data="data" :changeCallback="onChange" title="Text Input">
    <div class="mb-1 last:mb-0" v-show="fieldMeta.label !== ''">
      <label class="w-1/6 inline-block after:content-[':']" for="price">Price</label>
      <input class="w-5/6" type="number" name="price" v-model.trim="fieldMeta.price" @change="onChange({price:fieldMeta.price})">
    </div>
  </InputField>
  
</template>
<script>
import InputField from '@/admin/components/InputField.vue'
import {slugify} from '@/helper.js'
export default {
  name: 'TextInput',
  components:{
    InputField
  },
  props:{
    index:{
      type: Number
    },
    data:{
      type: Object,
      default: {}
    }
  },
  data() {
    return {
      fieldMeta:{
        price: '',
        label: '',
      },
    }
  },
  computed: {
    name(){
      return slugify(this.label)
    }
  },
  mounted() {
   this.fieldMeta.label = this.data.label || ''
    this.fieldMeta.price = this.data.price || ''
    this.fieldMeta = {...this.fieldMeta,...this.data}
  },
  methods: {
    onChange(meta={}){
      this.fieldMeta = {...this.fieldMeta, ...meta}
      const data = {
        label: this.fieldMeta.label,
        required: this.fieldMeta.required,
        description: this.fieldMeta.description,
        id: this.fieldMeta.id,
        name: this.fieldMeta.name,
        price: this.fieldMeta.price,
      }
      this.$emit('update', {'index': this.index, data})
    }
  },

}
</script>

<style>

</style>
