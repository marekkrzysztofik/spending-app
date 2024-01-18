<template>
    <div class="flex flex-column justify-content-center m-2">
        <div class="flex justify-content-center">
            <div class="balance-box">
                <h2>Twój balans</h2>
                <h1>{{ balance }} zł</h1>
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
        <div class="flex justify-content-center">
            <div class="balance-box">
                <Chart type="bar" :data="chartData" :options="chartOptions" />
            </div>
            <div class="balance-box">
                <h2>Ostatnie wydatki</h2>
                <table class="m-2">
                    <tr>
                        <th>Tytuł</th>
                        <th>Kwota</th>
                        <th>Data</th>
                    </tr>
                    <tr v-for="item in lastTransactions">
                        <th class="table">{{ item.title }}</th>
                        <th class="table">{{ item.amount }}</th>
                        <th class="table">{{ item.date }}</th>
                    </tr>
                </table>
            </div>
            <div class="balance-box">
                <h2>Ostatnie wydatki</h2>
                <table class="m-2">
                    <tr>
                        <th>Tytuł</th>
                        <th>Kwota</th>
                        <th>Data</th>
                    </tr>
                    <tr v-for="item in lastTransactions">
                        <th class="table">{{ item.title }}</th>
                        <th class="table">{{ item.amount }}</th>
                        <th class="table">{{ item.date }}</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, computed, ref, ComputedRef, Ref, watch } from "vue";
import { useRouter } from "vue-router";
import { useBudgets } from "@/../utils/useBudgets";
import { useIncomes } from "@/../utils/useIncomes";
import { visible } from "@/consts/modalVisibility";

const { getIncomes, incomes } = useIncomes();
const { getBudgets, budgets } = useBudgets();
const lastTransactions = ref()
const expenseSum = ref()
const incomeSum = ref()
const router = useRouter();
const labelArr: Array<any> = []
const sumArr: Array<any> = []
const limitArr: Array<any> = []
watch(
    () => visible.value,
    () => {
        getAlldata()
    }
)
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
    box-shadow: 0 1.5rem 2rem rgba(0, 0, 0, 0.15);
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
    width: 25%;
}
</style>
