import {defineStore} from 'pinia'

export const useEditorFields = defineStore('editorFields', {
  state: () => ({
    editorFields: [],
  }),
  actions: {
    loadFromJson(data) {
      this.editorFields = data
    },
    removeField(index){
      try {
        this.editorFields.splice(index, 1)
      } catch (error) {
        console.log('error removing field', index, error)
      }
    },
    moveField(from, to){
      if (0 > to || to > (this.editorFields.length -1 )) {
        console.log('invalid from, to index', from, to)
      } else {
        [this.editorFields[to], this.editorFields[from]] = [this.editorFields[from], this.editorFields[to]]
      }
    },
    updateField(index, data, merge=true){
      if (true === merge) {
        const currentData = this.editorFields[index]
        this.editorFields[index] = {...currentData, ...data}
      } else {
        this.editorFields[index] = data
      }
    },
    addField(data){
      this.editorFields.push(data)
    },
    onUpdate(){
    },
  },
})
