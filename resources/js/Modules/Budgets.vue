<template>
    <div class=flex>
        <div class="flex flex-column">
            <div @click="get(index)" v-for="(budget, index) in budgets" class="flex m-1 sidemenu-item">
                <Knob v-model="value" :size="50" readonly />
                <div class="ml-2">
                    <h3>{{ budget.name }}</h3>
                    <span>200 zł / {{ budget.amount }} zł</span>
                </div>

            </div>
        </div>
        <div class="m-5 animation">
            <DataTable :value="categories" responsiveLayout="scroll" class="datatable p-4" unstyled>
                <template #header>
                    {{ datatableHeader }}
                </template>
                <Column field="category_name" style="width: 26rem" />
                <Column field="category_limit" header="Zaplanowane" style="text-align:right" />
                <template #footer>
                    <p>Razem x transakcji w tym miesiącu.</p>
                    <Button @click="showModal" icon="pi pi-plus" label="Add new item" />
                </template>
            </DataTable>
            <Dialog v-model:visible="isModalOpen">
                <Categories :isModalOpen="isModalOpen" @close-modal="closeModal" />
            </Dialog>
        </div>
    </div>
</template>
<script setup lang="ts">
import { useBudgets } from "@/../utils/useBudgets";
import { useCategoriesByBudgetId } from "@/../utils/useCategoriesByBudgetId";
import AddExpense from "@/Components/AddExpense.vue";
import { onMounted, reactive, ref, Ref } from "vue";
import { useRouter } from "vue-router";

const { getBudgets, budgets } = useBudgets();
const { getCategoriesByBudgetId, categories } = useCategoriesByBudgetId();
const value = ref(40)
const isModalOpen = ref(false);
const datatableHeader: Ref = ref()

onMounted(async () => {
    getBudgets();
});
const get = async (id: any) => {
    const budgetID: number = budgets.value[id].id
    datatableHeader.value = budgets.value[id].name
    await getCategoriesByBudgetId(budgetID)

}
const showModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
    
};
</script>
<style scoped>
.sidemenu-item:hover {
    background-color: rgba(207, 207, 207);
    color: black;
    cursor: pointer;
}

.animation {
    transition: all 0.7s ease;
}

.datatable {
    background-color: white;
    border-radius: 10px;
}

.sidemenu-item {
    background-color: white;
    color: rgb(95, 95, 95);
    margin: 0.2rem auto;
    padding: 1rem;
    border-radius: 10px;
    transition: color 0.2s ease;
}
</style>