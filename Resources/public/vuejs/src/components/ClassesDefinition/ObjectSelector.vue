<script setup>

</script>

<template>
    <div>
        <select name="objectIds" v-model="selectedObjectId" @change="emitSelection" >
            <option v-for="objectId in this.objectIds" :value="objectId" :key="objectId">{{objectId}}</option>
        </select>
        <h1 style="color:white;">{{this.selectedObjectId}}</h1>
    </div>
</template>

<script>
export default {
    name: 'ObjectSelector',
    props: {
        objectIds: Array,
        value: String
    },
    data: () => {
        return {
            selectedObjectId: null
        }
    },
    methods: {
        emitSelection() {
            //this.value = this.selectedObjectId;
        }
    }
}
</script>

<style scoped>

</style>