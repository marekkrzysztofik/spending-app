<template>
    <div>
        <h4>Welcome back, Marek!</h4>
    </div>
    <div class="flex justify-content-center">
        <div class="balance-box">
            <h2>Total Balance</h2>
            <h1>52 222 zł</h1>
            <p>last month 49 858 zł</p>
        </div>
        <div class="balance-box">
            <h2>Twoje wydatki</h2>
            <h1>{{ expenseSum }} zł</h1>
            <p>last month 49 858 zł</p>
        </div>
        <div class="balance-box">
            <h2>Twoje przychody</h2>
            <h1>{{ incomeSum }} zł</h1>
            <p>last month 49 858 zł</p>
        </div>

    </div>
    <div>
        <router-link to="/add-expense" class="m-1"><Button label="Add Expense" icon="pi pi-plus" size="small" />
        </router-link>
        <router-link to="/" class="m-1"><Button label="Add Income" icon="pi pi-plus" size="small" /></router-link>
    </div>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, reactive, ref, Ref } from "vue";
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
    expenseCounter()
    incomesCounter()
});
const incomesCounter = () => {
    const incomesArray: Array<number> = []
    incomes.value.forEach((el) => {
        if (el.amount)
            incomesArray.push(el.amount);
    });
    if (incomesArray.length > 0)
        incomeSum.value = incomesArray.reduce((a, b) => a + b);
    incomeSum.value = separateThousands(incomeSum.value)
};
const expenseCounter = () => {
    const expensesArray: Array<number> = []
    budgets.value.forEach((el) => {
        if (el.transactions_sum_amount)
            expensesArray.push(el.transactions_sum_amount);
    });
    if (expensesArray.length > 0)
        expenseSum.value = expensesArray.reduce((a, b) => a + b);
    expenseSum.value = separateThousands(expenseSum.value)
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
