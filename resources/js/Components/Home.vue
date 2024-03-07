<template>
    <div class="flex flex-column justify-content-center mx-2">
        <div class="flex justify-content-center container">
            <div class="balance-box">
                <h2>Your balance</h2>
                <h1>{{ balance }} zł</h1>
            </div>
            <div class="balance-box"> 
                <h2>Your Expenses</h2>
                <h1>{{ expenseSum }} zł</h1>
            </div>
            <div class="balance-box">
                <h2>Your Incomes</h2>
                <h1>{{ incomeSum }} zł</h1>
            </div>
        </div>
        <div class="flex justify-content-center container">
            <div class="balance-box">
                <Chart type="bar" :data="chartData" :options="chartOptions" />
            </div>
            <div class="balance-box flex flex-column text-center">
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
            <div class="balance-box flex flex-column text-center">
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
import { userID } from "@/../utils/userID";
import { useIncomes } from "@/../utils/useIncomes";

const { getIncomes, incomes } = useIncomes();
const lastTransactions = ref()
const expenseSum = ref()
const incomeSum = ref()
const chartData: any = ref();
const chartOptions = ref({
    indexAxis: 'y',
    maintainAspectRatio: true,
    aspectRatio: 1,
});
onMounted(async () => {
    await getAlldata()
});
const balance: ComputedRef<number> = computed(() => {
    return incomeSum.value - expenseSum.value
})
const getAlldata = async () => {
    await getChartData()
    await getIncomes()
    await getLastTransactions()
    expenseSum.value = chartData.value.expenseSum
    incomeSum.value = counter(incomes.value, 'amount')
}
const getChartData = async () => {
    const response = await axios.get(`/api/getDataForHomePage/${userID}`);
    chartData.value = response.data;
}
const getLastTransactions = async () => {
    const response = await axios.get(`/api/getLastTransactionsByUserId/${userID}`);
    lastTransactions.value = response.data;
}
const counter = (array: Array<any>, prop: string) => {
    const arr: Array<number> = []
    array.forEach((el) => {
        if (el[prop])
            arr.push(parseInt(el[prop]));
    });
    if (arr.length > 0)
        return arr.reduce((a: number, b: number) => a + b);
    else return 0;
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
