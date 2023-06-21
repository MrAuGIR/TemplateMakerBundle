<script setup>

</script>

<template>
    <div>
        <select name="objectIds" v-model="selectedId" @change="sendDataToParent">
            <option
                v-for="objectId in this.objectIds"
                :value="objectId"
                :key="objectId"

            >{{objectId}}</option>
        </select>
    </div>
</template>

<script>
export default {
    name: 'ObjectSelector',
    props: {
        objectIds: Array,
    },
    data () {
      return {
          selectedId: null
      }
    },
    methods: {
        sendDataToParent() {
            const data = this.selectedId;
            this.$emit('update-object-id',data)
        }
    }

}
</script>

<style scoped>

</style>