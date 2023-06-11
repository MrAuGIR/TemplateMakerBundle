
<template>
    <div>
        hello world
    </div>
</template>

<script>

import {useClassDefinitionStore} from "@/stores/classDefinition";
export default {
    setup() {
        const classesDefinitionStore = useClassDefinitionStore()
        return {
            classesDefinitionStore
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
        }
    },
    mounted() {
        this.getClassDefinition()
    }
}
</script>

<style scoped>

</style>