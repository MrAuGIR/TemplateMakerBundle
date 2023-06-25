<script setup>

</script>

<template>
    <div>
        <div v-for="(value, key) in classDef" :key="key">
            <ElementDefinition :elementKey="key" :elementValues="value"></ElementDefinition>
        </div>
    </div>
</template>

<script>

import ElementDefinition from "@/components/ClassesDefinition/ElementDefinition.vue";

export default {
    components: {ElementDefinition},
    name : "ClassDefinition.vue",
    props: {
        classDef: Object
    }
}

</script>

<style scoped>

</style>