<template>
  <InputField :index="index" :changeCallback="onChange" title="Text Input" :field="field">
    <div class="mb-1 last:mb-0" v-show="field.data.label !== ''">
      <label class="w-1/6 inline-block after:content-[':']" for="price">Price</label>
      <input class="w-5/6" type="number" name="price" v-model.trim="field.data.price" @change="onChange">
    </div>
  </InputField>
  
</template>
<script>
import {useEditorFields} from '@/admin/stores/editor'
import InputField from '@/admin/components/InputField.vue'
import {slugify} from '@/helper.js'
export default {
  name: 'TextInput',
  components:{
    InputField
  },
  props:{
    index: {},
    field: {},
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
  },
  methods: {
    onChange(){
      useEditorFields().onUpdate()
    },
  },

}
</script>

<style>

</style>
