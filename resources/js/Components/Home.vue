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
                <h2>Total Balance</h2>
                <h1>52 222 zł</h1>
                <p>last month 49 858 zł</p>
            </div>
            <div class="balance-box">
                <h2>Total Balance</h2>
                <h1>52 222 zł</h1>
                <p>last month 49 858 zł</p>
            </div>

        </div>
        <div class="">
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
                    {{ item.date }}
                </div>
                <div class="p-20">{{ item.price }} zł</div>
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

interface Expense {
    name: string;
    date: number;
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


.balance-box {
    margin: 1rem;
    padding: 1rem;
    width: 35%;
    background-color: white;
    border-radius: 10px;
}
</style>
