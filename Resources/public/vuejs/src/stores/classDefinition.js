import { defineStore } from 'pinia'
export const useClassDefinitionStore = defineStore('classDefinition', {
    state: () => ({
        classes: []
    }),
    getters: {
        getClassById: (state) => {
            return (id) => state.classes.find((c) =>  c.id === id)
        },
        getClassByName: (state) => {
            return (name) => state.classes.find((c) => c.name === name)
        }
    }
})