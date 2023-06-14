
<template>
    <div>
        <div v-if="loaderActive">chargement en cours...</div>
        <div v-else>
            <list-class-definition-card
                v-for="classDef in this.classesDefinitionStore.classesDefinition.classes"
                :key="classDef.id"
                :class-def="classDef"
                @click="selectClassDef(classDef)"
            ></list-class-definition-card>
        </div>
        <div v-if="this.currentClassDefinition !== null">
            <class-definition :classDef="this.currentClassDefinition"></class-definition>
        </div>
    </div>
</template>

<script>

import {useClassDefinitionStore} from "@/stores/classDefinition";
import ListClassDefinitionCard from "@/components/ClassesDefinition/ListCard.vue";
import ClassDefinition from "@/components/ClassesDefinition/ClassDefinition.vue";
export default {
    components: {ClassDefinition, ListClassDefinitionCard},
    setup() {
        const classesDefinitionStore = useClassDefinitionStore()
        return {
            classesDefinitionStore
        }
    },
    data: () => {
        return {
            loaderActive: true,
            currentClassDefinition: null
        }
    },
    name : "ListClassesDefinition.vue",
    methods: {
        async getListClassDefinition () {
            // const headers = new Headers({
            //     "Authorization": ""
            // })

            const res = await fetch("http://localhost:8080/template/list/class", {
                method: "GET"
            });
            this.classesDefinitionStore.classesDefinition = await res.json();
            this.loaderActive = false;
        },
        async getClassDefinition (url) {
            const res = await fetch(`http://localhost:8080${url}`,{
                method: "GET"
            });
            this.currentClassDefinition = await res.json();
        },
        selectClassDef(classDef) {
            this.getClassDefinition(classDef.url)

        }
    },
    mounted() {
        this.getListClassDefinition()
    }
}
</script>

<style scoped>

</style>