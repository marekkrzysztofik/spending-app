<template>
    <div class="flex flex-column bg-dark-blue w-7 m-20-auto br-radius-15">
        <div class="m-auto">
            <h2 class="center">Edit Budget</h2>
            <div class="input-grid">
                <div>
                    <InputText v-model="budgetForm.name" type="text" placeholder="Name of competitor" class="m-3" />
                    <InputText type="text" placeholder="Surname of competitor" class="m-3" />
                </div>

                <div>
                    <p class="text-danger">

                    </p>
                </div>
                <p>
                    <Button label="Save" class="p-button-rounded m-3" />
                </p>
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
