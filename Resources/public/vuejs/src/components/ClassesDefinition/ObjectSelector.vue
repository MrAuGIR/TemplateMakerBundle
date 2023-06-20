<script setup>

</script>

<template>
    <div>
        <select name="objectIds">
            <option v-for="id in this.objectIds" :value="id" :key="id">{{id}}</option>
        </select>
    </div>
</template>

<script>
export default {
    name: 'ObjectSelector',
    props: {
        objectIds: Array
    }
}
</script>

<style scoped>

</style>