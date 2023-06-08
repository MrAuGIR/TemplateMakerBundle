import { defineStore } from 'pinia'
export const useClassDefinitionStore = defineStore('classDefinition', {
    state: () => ({
        classes: []
    }),
    getters: {
        getClassById: (state) => {
            return (id) => state.classes.find((class) =>  class.id === id)
        },
        getClassByName: (state) => {
            return (name) => state.classes.find((class) => class.name === name)
        }
    }
})