<template>
    <div class="container flex">
        <div>
            <div class="flex">
                <div class="p-20">
                    <h1>Expense</h1>
                </div>
                <div class="p-20">
                    <h1>{{ totalExpenses }}</h1>
                </div>
            </div>
            <div v-for="item in expenses" class="flex">
                <div class="p-20">{{ item.name }}</div>
                <div class="p-20">
                    {{ item.day }}. {{ item.month }}.
                    {{ item.year }}
                </div>
                <div class="p-20">{{ item.price }} zł</div>
            </div>
        </div>
        <div>
            <router-link to="/add-expense" class="m-1"><Button label="Add Expense" icon="pi pi-plus"
                    size="small" /></router-link>
            <router-link to="/" class="m-1"><Button label="Add Income" icon="pi pi-plus" size="small" /></router-link>
        </div>
    </div>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, reactive, ref, Ref } from "vue";
import { useRouter } from "vue-router";

interface Expense {
    name: string;
    day: number;
    month: number;
    year: number;
    price: number;
    time: string;
}
const router = useRouter();
const expensesArray: Array<number> = [];
const expenses: Ref<Array<Expense>> = ref([]);
const totalExpenses: Ref = ref();

onMounted(() => {
    const currentDate = new Date();
    const currentMonth: number = currentDate.getMonth() + 1;
    getExpensesByMonth(currentMonth);
});

const getExpensesByMonth = async (currentMonth: number) => {
    const response = await axios.get(
        `/api/getExpensesJoinedWithCategoriesByMonth/${currentMonth}`
    );
    expenses.value = response.data;
    expenseCounter();
};
const expenseCounter = () => {
    expenses.value.forEach((el) => {
        expensesArray.push(el.price);
    });
    if (expensesArray.length > 0)
        totalExpenses.value = expensesArray.reduce((a, b) => a + b);
};
</script>
<style scoped>
.m-auto {
    margin: auto;
}

.container {
    margin: auto;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
</style>
