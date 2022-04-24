<template>
  <InputField :index="index" :data="data" :changeCallback="onChange" title="Radio Group">
    <div class="field-meta flex items-center" v-show="fieldMeta.label !== ''">
      <label class="" for="type">Type</label>
      <div class="radio-group w-4/6 flex gap-2 items-center">
        <div class="text-center">
          <input class="block" type="radio" id="default" value="default"
          v-model="fieldMeta.type" @change="onChange">
          <label class="block" for="default">Default</label>
        </div>
        <div class="text-center">
          <input class="block" type="radio" id="color" value="color"
          v-model="fieldMeta.type" @change="onChange">
          <label class="block" for="color">Color</label>
        </div>
        <div class="text-center">
          <input class="block" type="radio" id="image" value="image"
          v-model="fieldMeta.type" @change="onChange">
          <label class="block" for="image">Image</label>
        </div>
      </div>
    </div>
    <div class="field-meta" v-show="fieldMeta.label !== ''">
      <label class="" for="type">Options</label>
      <div class="w-5/6 inline-block">
        <RadioOptions :options="fieldMeta.options"
        :radioType="fieldMeta.type" @updateOptions="updateOptions"/>
      </div>
    </div>
    <AddRadioOption :radioType="fieldMeta.type" @addOption="addOption" v-show="fieldMeta.label !== ''"/>
  </InputField>
  
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import {faTrashCan} from '@fortawesome/free-solid-svg-icons'
import InputField from '@/admin/components/InputField.vue'
import RadioOptions from '@/admin/components/RadioOptions.vue'
import AddRadioOption from '@/admin/components/AddRadioOption.vue'
library.add([faTrashCan])

export default {
  name: 'RadioInput',
  components:{
    InputField,
    RadioOptions,
    AddRadioOption
  },
  props:{
    data:{
      type: Object,
      default: {}
    },
    index: {},
  },
  data() {
    return {
      fieldMeta:{
        label: '',
        options: [],
        type: 'default',
      },
    }
  },
  mounted() {
    this.fieldMeta.label = this.data.label || ''
    this.fieldMeta.options = this.data.options || []
    this.fieldMeta.type = this.data.type || 'default'
    this.fieldMeta = {...this.fieldMeta,...this.data}
    console.log(this.fieldMeta)
  },
  methods: {
    onChange(meta={}){
      this.fieldMeta = {...this.fieldMeta, ...meta}
      const data = {
        label: this.fieldMeta.label,
        required: this.fieldMeta.required,
        description: this.fieldMeta.description,
        name: this.fieldMeta.name,
        id: this.fieldMeta.id,
        type: this.fieldMeta.type,
        options: this.fieldMeta.options,
      }
      this.$emit('update', {'index': this.index, data})
    },
    addOption(option){
      this.fieldMeta.options.push(option)
      this.onChange()
    },
    updateOptions(options){
      this.fieldMeta.options = options
      this.onChange()
    },
    
  },

}
</script>

<style>

</style>
