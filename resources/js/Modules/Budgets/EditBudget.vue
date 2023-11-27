<template>
    <div class="flex flex-column bg-dark-blue w-7 m-20-auto br-radius-15">
        <div class="m-auto">
            <h2 class="center">Edytuj Budget</h2>
            <div class="">
                <div class="flex">
                    <h4 class="m-auto">Nazwa</h4>
                    <InputText v-model="budgetForm.name" type="text" class="m-3" />
                </div>
                <div class="flex">
                    <h4 class="m-auto">Limit</h4>
                    <InputText v-model="budgetForm.limit" type="number" class="m-3" />
                </div>
                <Button label="Save" class="p-button-rounded m-3" />
            </div>
        </div>
    </div> 
</template>
<script setup lang="ts">
import axios from 'axios'
import { onMounted, ref, Ref } from "vue";
import { BudgetForm } from "@/types/budgetForm"
import { budget } from "@/consts/budgetID";

const budgetForm: Ref<BudgetForm> = ref({
    id: 0,
    name: '',
    limit: 0
})

onMounted(async () => {
    getSingleSportsman()
});
const getSingleSportsman = async () => {
    const response = await axios.get(`/api/getBudgetById/${budget.id}`);
    budgetForm.value = response.data;
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
</style>
