<template>
    <div class="flex flex-column justify-content-center mx-2">
        <div class="flex justify-content-center container">
            <div class="balance-box">
                <h2>Your balance</h2>
                <h1>{{ balance }} zł</h1>
                <p>last month 49 858 zł</p>
            </div>
            <div class="balance-box">
                <h2>Your Expenses</h2>
                <h1>{{ expenseSum }} zł</h1>
                <p>last month 49 858 zł</p>
            </div>
            <div class="balance-box">
                <h2>Your Incomes</h2>
                <h1>{{ incomeSum }} zł</h1>
                <p>last month 49 858 zł</p>
            </div>
        </div>
        <div class="flex justify-content-center container">
            <div class="balance-box">
                <Chart type="bar" :data="chartData" :options="chartOptions" />
            </div>
            <div class="balance-box flex flex-column">
                <h2>Last expenses</h2>
                <table class="m-2">
                    <tr>
                        <th class="table">Title</th>
                        <th class="table">Amount</th>
                        <th class="table">Date</th>
                    </tr>
                    <tr v-for="item in lastTransactions">
                        <td class="table"><span>{{ item.title }}</span></td>
                        <td class="table">{{ item.amount }} zł</td>
                        <td class="table">{{ item.date }}</td>
                    </tr>
                </table>
            </div>
            <div class="balance-box flex flex-column ">
                <h2>Last expenses</h2>
                <table class="m-2">
                    <tr>
                        <th class="table">Title</th>
                        <th class="table">Amount</th>
                        <th class="table">Date</th>
                    </tr>
                    <tr v-for="item in lastTransactions">
                        <td class="table"><span>{{ item.title }}</span></td>
                        <td class="table">{{ item.amount }} zł</td>
                        <td class="table">{{ item.date }}</td>
                    </tr>
                </table>
            </div>
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
const lastTransactions = ref()
const expenseSum = ref()
const incomeSum = ref()
const router = useRouter();
const labelArr: Array<any> = []
const sumArr: Array<any> = []
const limitArr: Array<any> = []

onMounted(async () => {
    await getAlldata()
});
const chartData: any = ref();
const chartOptions = ref({
    indexAxis: 'y',
    maintainAspectRatio: true,
    aspectRatio: 1,
});
const getAlldata = async () => {
    await getBudgets()
    await getIncomes()
    await getLastTransactions()
    incomeSum.value = counter(incomes, 'amount')
    expenseSum.value = counter(budgets, 'transactions_sum_amount')
    prepareDataForCharts()
}
const getLastTransactions = async () => {
    const response = await axios.get(`/api/getLastTransactionsByUserId/1`);
    lastTransactions.value = response.data;
}
const prepareDataForCharts = () => {
    budgets.value.forEach(budget => {
        labelArr.push(budget.name)
        sumArr.push(budget.transactions_sum_amount)
        limitArr.push(budget.limit)
    });
    setDataChart()
}
const setDataChart = () => {
    chartData.value = {
        labels: labelArr,
        datasets: [
            {
                label: 'Wydane',
                backgroundColor: ['#41B883'],
                data: sumArr
            },
            {
                label: 'Zaplanowane',
                backgroundColor: ['#E46651'],
                data: limitArr
            }
        ]
    }
}
const balance: ComputedRef<number> = computed(() => {
    return incomeSum.value - expenseSum.value
})
const counter = (array: Ref<Array<any>>, prop: string) => {
    const arr: Array<number> = []
    array.value.forEach((el) => {
        if (el[prop])
            arr.push(parseInt(el[prop]));
    });
    if (arr.length > 0)
        return arr.reduce((a, b) => a + b);
    else if (arr.length == 0)
        return 0;
};
</script>
<style scoped>
.balance-box {
    margin: 1rem 0.5rem 0;
    padding: 1.5rem 1rem;
    width: 35%;
    background-color: white;
    border-radius: 10px;
    transition: transform 0.3s;
}

.balance-box:hover {
    transform: translateY(-0.5rem) scale(1.01);
}

.chart-box {
    background-color: white;
    padding: 2rem;
}

.chart-width {
    width: 20vw;
}

.table {
    width: 20%;
    text-align: center;
    max-width: 7rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

@media screen and (min-width: 1900px) {
    .balance-box {
        margin: 2rem 0.5rem 0;
        padding: 2.5rem 1rem;
    }
}

@media screen and (max-width: 900px) {
    .container {
        flex-direction: column;
    }

    .balance-box {
        width: 80%;
        background-color: white;
        border-radius: 10px;
        transition: transform 0.3s;
    }
}
</style>
