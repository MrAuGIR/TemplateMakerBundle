
<template>
    <div class="main-content">
        <div class="left-side">
            <div v-if="loaderActive">chargement en cours...</div>
            <div v-else>
                <list-class-definition-card
                    v-for="classDef in this.classesDefinitionStore.classesDefinition.classes"
                    :key="classDef.id"
                    :class-def="classDef"
                    @click="selectClassDef(classDef)"
                ></list-class-definition-card>
            </div>
        </div>
        <div class="current-class-column">
            <div v-if="this.listObjectIds !== null">
                <ObjectSelector :object-ids="this.listObjectIds" @update-object-id="handleChangeId"></ObjectSelector>
            </div>
            <div v-if="this.currentClassDefinition !== null">
                <class-definition :classDef="this.currentClassDefinition"></class-definition>
            </div>
        </div>
    </div>
</template>

<script>

import {useClassDefinitionStore} from "@/stores/classDefinition";
import ListClassDefinitionCard from "@/components/ClassesDefinition/ListCard.vue";
import ClassDefinition from "@/components/ClassesDefinition/ClassDefinition.vue";
import ObjectSelector from "@/components/ClassesDefinition/ObjectSelector.vue";
export default {
    components: {ObjectSelector, ClassDefinition, ListClassDefinitionCard},
    setup() {
        const classesDefinitionStore = useClassDefinitionStore()
        return {
            classesDefinitionStore
        }
    },
    data: () => {
        return {
            loaderActive: true,
            currentClassDefinition: null,
            listObjectIds: [],
            selectedObjectId: null,
            currentUriClassDef: null,
        }
    },
    name : "ListClassesDefinition.vue",
    methods: {
        async getListClassDefinition () {
            // const headers = new Headers({
            //     "Authorization": ""
            // })

            const res = await fetch("http://localhost:8080/template/list/class", {
                method: "GET"
            });
            this.classesDefinitionStore.classesDefinition = await res.json();
            this.loaderActive = false;
        },
        async getClassDefinition (url) {
            const res = await fetch(`http://localhost:8080${url}`,{
                method: "GET"
            });
            this.currentClassDefinition = await res.json();
        },
        selectClassDef(classDef) {
            this.currentUriClassDef = classDef.url
            this.getClassDefinition(classDef.url);
            this.getObjects(classDef.listObjectUri);
            this.selectedObjectId = null;

        },
        async getObjects (uri) {
            const res = await fetch(`http://localhost:8080${uri}`, {
                method: "GET"
            });
            let listObjectIds = await res.json();
            this.listObjectIds = listObjectIds.ids;
        },
        async getClassDefinitionHydrated (objectId) {
            const res = await fetch(`http://localhost:8080${this.currentUriClassDef}/${objectId}`,{
                method: "GET"
            });
            this.currentClassDefinition = await res.json()
        },
        handleChangeId(id) {
            this.selectedObjectId = id
        }
    },
    mounted() {
        this.getListClassDefinition()
    },
    watch: {
        selectedObjectId: {
            immediate: true,
            handler(newValue) {
                if (newValue !== null) {
                    this.getClassDefinitionHydrated(newValue)
                }
            }
        }
    }
}
</script>

<style scoped>

    .main-content {
        display: flex;
        flex-direction: row;
        width: 100%;
        max-width: 1200px;
    }

    .left-side {
        display: flex;
        flex-direction: column;
        width: 33%;
    }

    .current-class-column {
        display: flex;
        flex-direction: column;
        width: 77%;
    }

</style>