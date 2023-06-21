<script setup>

</script>

<template>
    <div class="class-element-definition">
        <div class="class-element-label">
            <label>{{ this.elementKey }}</label>
        </div>
        <div class="class-element-values">
            <div class="element-value" v-for="(data, key) in elementValues" :key="key">
                <span>{{key}} : </span>
                <span>{{ data }} </span>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name : "ElementDefinition.vue",
    props: {
        elementKey: String,
        elementValues: Object
    }
}

</script>

<style scoped>
    .class-element-definition {
        display: flex;
        flex-direction: column;
        padding: 0.2rem;
    }

    .class-element-label {
        display: flex;
        padding: 1rem 0;
    }

    .class-element-values {
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
    }

</style>