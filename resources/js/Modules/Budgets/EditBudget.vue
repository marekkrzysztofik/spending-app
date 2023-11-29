<template>
    <div class="flex flex-column w-7 m-20-auto br-radius-15">

        <form @submit.prevent="onSubmit" class="m-auto">
            <h2 class="center">Edytuj Budget</h2>
            <div class="">
                <div class="flex">
                    <h4 class="m-auto">Nazwa</h4>
                    <InputText v-model="budgetForm.name" type="text" class="m-3" required />
                </div>
                <div class="flex">
                    <h4 class="m-auto">Limit</h4>
                    <input v-model.number="budgetForm.limit" type="number" class="m-3 input" required />
                </div>

                <Button type="submit" label="Save" class="p-button-rounded m-3" />
            </div>
        </form>
    </div>
</template> 
<script setup lang="ts">
import axios from 'axios'
import { onMounted, ref, Ref, defineEmits } from "vue";
import { Budget } from "@/types/budget";
import { budget } from "@/consts/budgetID";
import { BudgetForm } from '@/types/budgetForm';


const emit = defineEmits(['refresh']);
const budgetForm: Ref<BudgetForm> = ref({
    name: '',
    limit: 0
})

onMounted(async () => {
    getSingleBudget()
});
const getSingleBudget = async () => {
    const response = await axios.get(`/api/budgets/${budget.id}`);
    budgetForm.value = response.data;
};
const onSubmit = async () => {
    await axios.patch(`/api/budgets/${budget.id}`, budgetForm.value)
    emit('refresh')
};
</script>
<style scoped>
.input-grid {
    margin: auto;
    display: grid;
    align-items: center;
    grid-template-columns: repeat(2, 250px);
    grid-template-rows: repeat(2, 1fr);
    grid-column-gap: 0px;
    grid-row-gap: 0px;
}

.input {
    border: 0.1rem solid rgba(182, 187, 196, 0.3);
    border-radius: 0.2rem;
    padding: 0.3rem;
    transition: all 0.2s ease-in;
}

.input:focus {
    box-shadow: 0 0 0 0.2rem #a6d5fa;
}

.input:hover,
.input:focus {

    border-color: #2196F3;
}
</style>
