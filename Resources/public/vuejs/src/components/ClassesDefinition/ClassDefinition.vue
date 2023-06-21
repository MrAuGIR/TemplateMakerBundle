<script setup>

</script>

<template>
    <div>
        <div v-for="(value, key) in classDef" :key="key">
            <ElementDefinition :elementKey="key" :elementValues="value"></ElementDefinition>
<!--            <label>{{ key }}</label>  <br>-->
<!--            <span v-for="(data, key) in value" :key="key">-->
<!--               {{key}} :-->
<!--            {{ data }}-->
<!--            </span>-->
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