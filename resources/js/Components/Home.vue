<template>
    <div>
        <h4>Welcome back, Marek!</h4>
    </div>
    <div class="flex justify-content-center">
        <div class="balance-box">
            <h2>Twój balans</h2>
            <h1>{{ balance ? 0 : 0 }} zł</h1>
            <p>last month 49 858 zł</p>
        </div>
        <div class="balance-box">
            <h2>Twoje wydatki</h2>
            <h1>{{ expenseSum ? 0 : 0 }} zł</h1>
            <p>last month 49 858 zł</p>
        </div>
        <div class="balance-box">
            <h2>Twoje przychody</h2>
            <h1>{{ incomeSum ? 0 : 0 }} zł</h1>
            <p>last month 49 858 zł</p>
        </div>

    </div>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, computed, ref, ComputedRef, Ref } from "vue";
import { useRouter } from "vue-router";
import { useBudgets } from "@/../utils/useBudgets";
import { useIncomes } from "@/../utils/useIncomes";

const { getIncomes, incomes } = useIncomes();
const { getBudgets, budgets } = useBudgets();

const expenseSum = ref()
const incomeSum = ref()
const router = useRouter();

onMounted(async () => {
    await getBudgets()
    await getIncomes()
    incomeSum.value = counter(incomes, 'amount')
    expenseSum.value = counter(budgets, 'transactions_sum_amount')
});
const balance: ComputedRef<number> = computed(() => {
    return incomeSum.value - expenseSum.value
})
const counter = (array: Ref<Array<any>>, prop: string) => {
    const arr: Array<number> = []
    array.value.forEach((el) => {
        if (el[prop])
            arr.push(el[prop]);
    });
    if (arr.length > 0)
        return arr.reduce((a, b) => a + b);
};

function separateThousands(number: number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
}
</script>
<style scoped>
.balance-box {
    margin: 1rem;
    padding: 1rem;
    width: 35%;
    background-color: white;
    border-radius: 10px;
}
</style>
