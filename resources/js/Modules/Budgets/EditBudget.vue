<template>
    <div class="flex flex-column m-20-auto br-radius-15">
        <form @submit.prevent="onSubmit" class="m-auto">
            <h2 class="center">Edytuj Budget</h2>
            <div class="flex">
                <h4 class="m-auto">Nazwa</h4>
                <input v-model="budgetForm.name" type="text" class="m-3 input" required />
            </div>
            <div class="flex">
                <h4 class="m-auto">Limit</h4>
                <input v-model.number="budgetForm.limit" type="number" class="m-3 input" required />
            </div>
            <button type="submit" class="button m-3">Save</button>
        </form>
    </div>
</template> 
<script setup lang="ts">
import axios from 'axios'
import { onMounted, ref, Ref, defineEmits } from "vue";
import { Budget } from "@/types/budget";
import { budget } from "@/consts/budgetID";
import { BudgetForm } from '@/types/budgetForm';

const props = defineProps({
    id: {
        type: Number,
        default: 0,
    },
});
const emit = defineEmits(['refresh']);
const budgetForm: Ref<BudgetForm> = ref({
    name: '',
    limit: 0
})
onMounted(async () => {
    getSingleBudget()
});
const getSingleBudget = async () => {
    const response = await axios.get(`/api/budgets/${props.id}`);
    budgetForm.value = response.data;
};
const onSubmit = async () => {
    await axios.patch(`/api/budgets/${props.id}`, budgetForm.value).then(() => {
        emit('refresh');
    });
};
</script>

 