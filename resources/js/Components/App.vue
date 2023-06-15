<template>
    <router-view />
</template>
<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const items = ref([
    {
        label: "Teacher",
        icon: "pi pi-fw pi-file",
        items: [
            {
                label: "Add",
                icon: "pi pi-plus",
                command: () => {
                    router.push("/add-teacher");
                },
            },
            {
                label: "Add subject",
                icon: "pi pi-plus",
                command: () => {
                    router.push("/add-subject");
                },
            },
            {
                label: "Add student",
                icon: "pi pi-plus",
                command: () => {
                    router.push("/add-student");
                },
            },
        ],
    },
]);
</script>
<style scoped>

</style>
