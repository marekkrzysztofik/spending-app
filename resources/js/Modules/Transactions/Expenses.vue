<template>
    <div class="m-3">
        <Calendar @date-select="changeDate(selectedMonth)" v-model="selectedMonth" view="month" dateFormat="mm-yy"
            placeholder="Select month" />
    </div>
    <ScrollPanel style="height: 80vh">
        <div class=" mt-5 flex flex-column">
            <div class="w-10 m-auto">
                <h2 class="m-3"></h2>
                <Chart type="line" :data="chartData" :options="chartOptions" class="h-50rem" />
            </div>
        </div>
    </ScrollPanel>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, ref, Ref } from "vue";
import { useDate } from "@/../utils/useDate";
import { userID } from "@/../utils/userID";

interface DailyExpense {
    day: string;
    total: number;
}
const { getMonth, getYear } = useDate()
const chartData = ref();
const chartOptions = ref();
const selectedMonth = ref()
onMounted(() => {
    getCategoriesForAnalytics(getMonth(), getYear())
    chartOptions.value = setChartOptions()
});
const getCategoriesForAnalytics = async (month: number, year: number) => {
    const response = await axios.get(`/api/getWeeklyExpenses/${userID}/${month}/${year}`)
    const budgetsWithCategories = response.data
    chartData.value = setChartData(budgetsWithCategories)
}
const setChartData = (dailyExpenses: any) => {
    return {
        labels: dailyExpenses.labels,
        datasets: [
            {
                label: 'Expenses',
                data: dailyExpenses.expenses,
                fill: false,
                borderColor: '#41B883',
                tension: 0.1
            },
        ]
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    return {
        plugins: {
            legend: {
                labels: {
                    usePointStyle: true,
                    color: textColor
                }
            }
        }
    };
};
const changeDate = (date: Date) => {
    getCategoriesForAnalytics(getMonth(date), getYear(date))
}
</script>