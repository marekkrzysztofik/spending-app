<template>
    <Dropdown class="m-5" v-model="shareForm.budget_id" :options="budgets" optionLabel="name" optionValue="id" />
    <DataTable :value="users" v-model:selection="selectedUsers" selectionMode="single" dataKey="id"
        :metaKeySelection="false" responsiveLayout="scroll" :scrollable="true" scrollHeight="400px"
        class="datatable w-30rem m-2">
        <template #header>Users </template>
        <Column field="id"></Column>
        <Column field="name"></Column>
        <Column field="surname"></Column>
    </DataTable>

    <button type="button" @click="save"></button>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, reactive, ref, Ref, defineEmits } from "vue";
import { useRouter } from "vue-router";
import { useUsers } from "@/../utils/useUsers";
import { useBudgets } from "@/../utils/useBudgets";

const { getBudgets, budgets } = useBudgets();
const { getUsers, users } = useUsers();
const selectedUsers = ref()

onMounted(() => {
    getUsers();
    getBudgets()
});
const shareForm = reactive({
    user_id: 0,
    budget_id: 0
})
const save = () => {
    shareForm.user_id = selectedUsers.value.id
    //  shareForm.budget_id = 
    console.log(shareForm)
}
</script> 