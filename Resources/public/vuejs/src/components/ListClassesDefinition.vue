
<template>
    <div>
        <div v-if="loaderActive">chargement en cours...</div>
        <div v-else>
            <list-class-definition-card v-for="classDef in this.classesDefinitionStore.classesDefinition.classes" :class-def="classDef"></list-class-definition-card>
        </div>
    </div>
</template>

<script>

import {useClassDefinitionStore} from "@/stores/classDefinition";
import ListClassDefinitionCard from "@/components/ClassesDefinition/ListCard.vue";
export default {
    components: {ListClassDefinitionCard},
    setup() {
        const classesDefinitionStore = useClassDefinitionStore()
        return {
            classesDefinitionStore
        }
    },
    data: () => {
        return {
            loaderActive: true,
        }
    },
    name : "ListClassesDefinition.vue",
    methods: {
        async getClassDefinition () {
            // const headers = new Headers({
            //     "Authorization": ""
            // })

            const res = await fetch("http://localhost:8080/template/list/class", {
                method: "GET"
            });
            this.classesDefinitionStore.classesDefinition = await res.json();
            this.loaderActive = false;
        }
    },
    mounted() {
        this.getClassDefinition()
    }
}
</script>

<style scoped>

</style>