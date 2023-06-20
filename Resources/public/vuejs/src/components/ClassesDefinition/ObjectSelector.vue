<script setup>

</script>

<template>
    <div>
        <select name="objectIds">
            <option v-for="objectId in this.objectIds" :value="objectId" :key="objectId">{{objectId}}</option>
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