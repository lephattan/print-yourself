<template>
  <InputField :index="index" title="Radio Group" :field="field">
    <div class="field-meta flex items-center" v-show="field.data.label !== ''">
      <label class="" for="type">Type</label>
      <div class="radio-group w-4/6 flex gap-2 items-center">
        <div class="text-center">
          <input class="block" type="radio" id="default" value="default"
          v-model="field.data.type" @change="onChange">
          <label class="block" for="default">Default</label>
        </div>
        <div class="text-center">
          <input class="block" type="radio" id="color" value="color"
          v-model="field.data.type" @change="onChange">
          <label class="block" for="color">Color</label>
        </div>
        <div class="text-center">
          <input class="block" type="radio" id="image" value="image"
          v-model="field.data.type" @change="onChange">
          <label class="block" for="image">Image</label>
        </div>
      </div>
    </div>
    <div class="field-meta" v-show="field.data.label !== ''">
      <label class="" for="type">Options</label>
      <div class="w-5/6 inline-block">
        <RadioOptions :options="field.data.options"
        :radioType="field.data.type" @updateOptions="updateOptions"/>
      </div>
    </div>
    <AddRadioOption :radioType="field.data.type" @addOption="addOption" v-show="field.data.label !== ''"/>
  </InputField>
  
</template>

<script>
import {useEditorFields} from '@/admin/stores/editor'
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
    index: {},
    field: {},
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
    //Set default value for type 
    if (undefined === this.field.data.type){
      this.field.data.type = 'default'
      this.onChange()
    }
    if (undefined === this.field.data.options ) {
      this.field.data.options = []
      this.onChange()
    }
  },
  methods: {
    onChange(){
      useEditorFields().onUpdate()
    },
    addOption(option){
      this.field.data.options.push(option)
      this.onChange()
    },
    updateOptions(options){
      this.field.data.options = options
      this.onChange()
    },
    
  },

}
</script>

<style>

</style>
