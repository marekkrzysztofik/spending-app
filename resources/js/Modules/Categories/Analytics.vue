<template>
    <div>
        <Chart v-for="chart in chartData" type="pie" :data="chart" :options="chartOptions" class="w-full md:w-30rem" />
    </div>
</template>
<script setup lang="ts">
import axios from "axios";
import { useBudgets } from "@/../utils/useBudgets";
import { onMounted, ref, Ref } from "vue";

import { useDate } from "@/../utils/useDate";

import { userID } from "@/../utils/userID";

const { getBudgets, budgets } = useBudgets();
const { getMonth, getYear } = useDate()

const budgetsWithCategories = ref()
const chartData = ref(); 
const chartOptions = ref();
onMounted(async () => {
    await getBudgetsWithCategories()
    // chartData.value = setChartData()
    chartOptions.value = setChartOptions()
});

const getBudgetsWithCategories = async () => {
    const response = await axios.get(`/api/getCategoriesForAnalytics/${userID}/${getMonth()}/${getYear()}`)
    const budgetsWithCategories = response.data
    console.log(budgetsWithCategories)
    setChartData(budgetsWithCategories)
}
const setChartData = (arr: Array<any>) => {
    const documentStyle = getComputedStyle(document.body);
    chartData.value = arr.map((item) => {
        return {
            labels: item.labels,
            datasets: [
                {
                    data: item.categories_sum,
                    backgroundColor: [documentStyle.getPropertyValue('--cyan-500'), documentStyle.getPropertyValue('--orange-500'), documentStyle.getPropertyValue('--gray-500')],
                    hoverBackgroundColor: [documentStyle.getPropertyValue('--cyan-400'), documentStyle.getPropertyValue('--orange-400'), documentStyle.getPropertyValue('--gray-400')]
                }
            ]
        };
    });
    console.log(chartData.value)
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
const changeDate = async (date: any) => {
    await getBudgets(getMonth(date), getYear(date), 2);


}

</script>