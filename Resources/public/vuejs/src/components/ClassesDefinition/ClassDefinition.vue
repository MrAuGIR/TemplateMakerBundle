<script setup>

</script>

<template>
    <div>
        <div v-for="(value, key) in classDef" :key="key">
            <label>{{ key }}</label> : <br>
            <span v-for="(data,key) in value" :key="key">{{key}} : {{data}}</span>
        </div>
    </div>
</template>

<script>

export default {
    name : "ClassDefinition.vue",
    props: {
        classDef: Object
    }
}

</script>

<style scoped>

</style>