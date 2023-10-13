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
        <div v-if="transactions.length" class="m-5 animation">
            <h1>
                Transaction History
            </h1>
            <DataTable :value="transactions" responsiveLayout="scroll" class="datatable m-20-auto" unstyled>
                <Column v-for="column in transactionsColumns" :key="column.field" :field="column.field"
                    :header="column.header" :style="column.style"></Column>
                <template #footer>
                    Razem x transakcji w tym miesiącu.
                </template>
            </DataTable>
        </div>
    </div>
</template>
<script setup lang="ts">
import { useBudgets } from "@/../utils/useBudgets";
import { useTransactionsWithCategories, transactionsColumns } from "@/../utils/useTransactionsWithCategories";
import { onMounted, reactive, ref, Ref } from "vue";
import { useRouter } from "vue-router";

const { getBudgets, budgets } = useBudgets();
const { getTransactionsByCategoryId, transactions } = useTransactionsWithCategories();
const value = ref(40)
onMounted(async () => {
    getBudgets();
});

const get = async (id: any) => {
    const budgetID: number = budgets.value[id].id
    await getTransactionsByCategoryId(budgetID)
    console.log(transactions.value)
}
</script>
<!-- <style scoped>
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
    width: 30vw;
}

.sidemenu-item {
    background-color: white;
    color: rgb(95, 95, 95);
    margin: 0.2rem auto;
    padding: 1rem;
    border-radius: 10px;
    transition: color 0.2s ease;
}
</style> -->