<template>
  <div class="m-4">
    <div class="flex">
      <h1 v-if="!budgets.length">No budgets</h1>
      <div>
        <Calendar @date-select="changeDate(selectedMonth)" v-model="selectedMonth" view="month" dateFormat="mm-yy"
          placeholder="Select month" />
      </div>
    </div>
    <ScrollPanel style="height: 75vh">
      <div class="grid">
        <div class="item-box text-center">
          <div class="">
            <h3>Add new budget</h3>
            <div @click="visible = true" class='new-budget button'>
              <i class="pi pi-plus m-auto" />
            </div>
          </div>
        </div>
        <div @click="link(index)" v-for="(budget, index) in chartData" :key="index" class="item-box text-center">
          <div class="">
            <h3>{{ budget.name }}</h3>
            <Chart type="doughnut" :data="budget" class="chart-width" />
            <span>{{ budget.expenseSum }} / {{ budget.categorySum }} zł</span>
          </div>
        </div>
      </div>
    </ScrollPanel>
    <Dialog v-model:visible="visible" modal>
      <AddNewBudget @close-modal="closeModal" />
    </Dialog>
  </div>
</template>
<script setup lang="ts">
import { useBudgets } from "@/../utils/useBudgets";
import { onMounted, ref, Ref } from "vue";
import { useRouter } from "vue-router";
import { budget } from "@/consts/budgetID"
import AddNewBudget from "./AddNewBudget.vue";
import { useDate } from "@/../utils/useDate";
import { userID } from "@/../utils/userID";

const router = useRouter();
const { getMonth, getYear } = useDate();
const { getBudgets, budgets } = useBudgets();
const visible = ref(false)
const selectedMonth = ref()
const chartData = ref()

onMounted(async () => {
  await getBudgets(getMonth(), getYear());
  prepareDataForCharts()
});
const changeDate = async (date: Date) => {
  await getBudgets(getMonth(date), getYear(date))
  prepareDataForCharts()
}
const closeModal = (id: number) => {
  visible.value = false
}
const link = (id: any) => {
  budget.id = budgets.value[id].id
  router.push('/categories')
}

const prepareDataForCharts = () => {
  chartData.value = budgets.value.map((item) => {
    return {
      name: item.name,
      categorySum: item.category_limit_sum,
      expenseSum: item.transactions_sum,
      labels: ['Spent', 'Planned',],
      datasets:
        [
          {
            data: [item.transactions_sum, item.category_limit_sum],
            backgroundColor: ['#E46651', '#41B883']
          }],
    };
  });
  console.log(chartData.value)
}
</script>
<style scoped>
.chart-width {
  width: 8rem;
}

.new-budget {
  min-width: 9rem;
  margin-top: 1rem;
  display: flex;
  padding: 1.3rem 0;
  background-color: var(--green);
}

.new-budget:hover {
  background-color: rgba(65, 184, 131, 0.6)
}

.item-box {
  height: 30vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: white;
  border-radius: 15px;
  transition: transform 0.3s;
}

.item-box:hover {
  transform: translateY(-0.4rem) scale(1.01);
}

.grid {
  margin: 2vw 0;
  display: grid;
  align-items: center;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(1fr);
  grid-column-gap: 2vw;
  grid-row-gap: 2vw;
}
</style>