import { defineStore } from 'pinia'
export const useClassDefinitionStore = defineStore('classDefinition', {
    state: () => {
        return {
            classesDefinition: []
        }
    },
    getters: {
        getClassById: (state) => {
            return (id) => state.classesDefinition.find((c) =>  c.id === id)
        },
        getClassByName: (state) => {
            return (name) => state.classesDefinition.find((c) => c.name === name)
        }
    }
})