<template>
    <div class="m-3">
        <Calendar @date-select="changeDate(selectedMonth)" v-model="selectedMonth" view="month" dateFormat="mm-yy"
          placeholder="Select month" />
      </div>
    <ScrollPanel style="height: 75vh">
        <div class="chart-grid mt-5">
            <div v-for="chart in chartData" class="flex flex-column justify-content-center text-center">
                <h2 class="m-3">{{chart.name}}</h2>
                <Chart type="pie" :data="chart" :options="chartOptions" class="w-10 m-auto" />
            </div>
        </div>
    </ScrollPanel>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, ref, Ref } from "vue";
import { useDate } from "@/../utils/useDate";
import { userID } from "@/../utils/userID";

const { getMonth, getYear } = useDate()
const chartData = ref();
const chartOptions = ref();
const selectedMonth = ref()
onMounted(() => {
    getCategoriesForAnalytics(getMonth(),getYear())
    chartOptions.value = setChartOptions()
});
const getCategoriesForAnalytics = async (month:number, year:number) => {
    const response = await axios.get(`/api/getCategoriesForAnalytics/${userID}/${month}/${year}`)
    const budgetsWithCategories = response.data
    console.log(budgetsWithCategories)
    setChartData(budgetsWithCategories)
}
const setChartData = (arr: Array<any>) => {
    const documentStyle = getComputedStyle(document.body);
    chartData.value = arr.map((item) => {
        return {
            name: item.name,
            labels: item.labels,
            datasets: [
                {
                    data: item.categories_sum,
                    backgroundColor: ['#41B883', '#E46651', documentStyle.getPropertyValue('--gray-500')],
                    hoverBackgroundColor: ['#41B883', '#E46651', documentStyle.getPropertyValue('--gray-400')]
                }
            ] 
        };
    });
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
    getCategoriesForAnalytics(getMonth(date),getYear(date))
}
</script>