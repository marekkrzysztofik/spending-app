<template>
    <form @submit.prevent="onSubmit" class="flex">
        <div class="m-auto p-3">
            <h2 class="m-1">Nazwa budżetu</h2>
            <input v-model="budgetForm.name" type="text" placeholder="Nazwa" class="input" required />
            <button class="w-min m-3 button" type="submit">Save</button>
        </div>
        
    </form>
</template>

<script setup lang="ts">
import axios from "axios";
import { reactive, defineEmits } from "vue";
import { userID } from "@/../utils/userID";

interface BudgetForm {
    user_id: number;
    name: string;
}

const emit = defineEmits(['close-modal']);
const budgetForm: BudgetForm = reactive({
    user_id: userID,
    name: '',
});

const closeModal = () => {
    emit('close-modal', budgetForm.user_id);
};
const onSubmit = () => {
    save()
}
const save = async () => {
    await axios
        .post("/api/budgets", budgetForm)
        .then(() => {
            closeModal()
        });
};
</script>
