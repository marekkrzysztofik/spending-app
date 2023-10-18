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
    </div>
</template>
<script setup lang="ts">
import { useBudgets } from "@/../utils/useBudgets";
import { useCategoriesByBudgetId } from "@/../utils/useCategoriesByBudgetId";
import AddExpense from "@/Components/AddExpense.vue";
import { onMounted, reactive, ref, Ref } from "vue";
import { useRouter } from "vue-router";
const router = useRouter();
const { getBudgets, budgets } = useBudgets();
const { getCategoriesByBudgetId, categories } = useCategoriesByBudgetId();
const value = ref(40)

onMounted(async () => {
    getBudgets();
});
const budgetID = ref();
const get = async (id: any) => {
    budgetID.value = budgets.value[id].id
    // datatableHeader.value = budgets.value[id].name
    // await getCategoriesByBudgetId(budgetID.value)
    router.push(`/category/${budgetID.value}`);
}
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