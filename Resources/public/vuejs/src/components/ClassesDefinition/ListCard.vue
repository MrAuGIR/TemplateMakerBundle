<script setup>

</script>

<template>
    <div class="class-def-card">
        <div class="class-def-card-id">
            <span class="class-def-card-id-content">{{ this.classDef.id }} : {{this.classDef.name}}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "listClassDefinitionCard",
    props: {
        classDef: Object
    },
    data () {
        return {

        }
    }
}
</script>

<style scoped>
    .class-def-card {
        display: flex;
        flex-direction: column;
        padding: 0.2rem 0.5rem;
    }

    .class-def-card-id {
        display: flex;
        min-height: 2rem;
        align-items: center;
    }

    .class-def-card-id:hover {
        background-color: #0c5460;
    }

    .class-def-card-id-content {

    }
</style>