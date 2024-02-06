<template>
  <div class="m-4">
    <div class="flex justify-content-between option-bar">
      <div>
        <button @click="selectComponent(2)" class="button">Private</button>
        <button @click="selectComponent(1)" class="button ml-3">Common</button>
      </div>
      <h1 v-if="!budgets.length">No budgets</h1>
      <div class="flex-end">
        <Calendar @date-select="changeDate(selectedMonth)" class="ml-3" v-model="selectedMonth" view="month"
          dateFormat="mm-yy" placeholder="Wybierz miesiąc" />
      </div>
    </div>
    <ScrollPanel style="width: 100%; height: 70vh">
      <div class="grid">
        <div class="m-1 item-box">
          <div class="ml-2">
            <h3>Add new budget</h3>
            <div @click="visible = true" class='new-budget button'>
              <i class="pi pi-plus m-auto" />
            </div>
          </div>
        </div>
        <div @click="link(index)" v-for="(budget, index) in chartData" :key="index" class="m-1 item-box">
          <div class="ml-2">
            <h3>{{ budget.name }}</h3>
            <Chart type="doughnut" :data="budget" class="chart-width" />
            <span>{{ budget.sum }} / {{ budget.limit }} zł</span>
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
import { onMounted, ref, Ref, shallowRef } from "vue";
import { useRouter } from "vue-router";
import { Budget } from "@/types/budget";
import { budget } from "@/consts/budgetID"
import AddNewBudget from "./AddNewBudget.vue";
import { useDate } from "../../../utils/useDate";


const router = useRouter();
const { getMonth, getYear } = useDate();
const { getBudgets, budgets } = useBudgets();
const chartData = ref()
const visible = ref(false)
const selectedMonth = ref()

onMounted(async () => {
  budget.month = getMonth();
  budget.year = getYear();
  await getBudgets(getMonth(), getYear(), 2);
  prepareDataForCharts(budgets)
});

const changeDate = async (date: any) => {
  budget.month = getMonth(date);
  budget.year = getYear(date);
  await getBudgets(getMonth(date), getYear(date), 2)
  prepareDataForCharts(budgets)
}
const selectComponent = async (id: number) => {
  await getBudgets(getMonth(), getYear(), id);
  prepareDataForCharts(budgets)
}

const prepareDataForCharts = (array: Ref<Array<Budget>>) => {
  chartData.value = array.value.map((item) => {
    return {
      name: item.name,
      sum: item.categories_sum_category_limit,
      limit: item.limit,
      labels: ['A', 'B',],
      datasets:
        [{
          data: [item.categories_sum_category_limit, item.limit],
          backgroundColor: ['#E46651', '#41B883']
        },
        {
          data: [item.transactions_sum_amount, item.categories_sum_category_limit],
          backgroundColor: ['#E46651', '#41B883']
        }],
    };
  });
}
const closeModal = async () => {
  // await getBudgets(budget.month, budget.year);
  selectComponent(0)
  visible.value = false
}
const link = (id: any) => {
  budget.id = budgets.value[id].id
  router.push('/categories')
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
  height: 28vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  background-color: white;
  border-radius: 15px;
  transition: transform 0.3s;
}

.item-box:hover {
  transform: translateY(-0.4rem) scale(1.01);
}

.grid {
  display: grid;
  align-items: center;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(2, 35vh);
  grid-column-gap: 1rem;
  grid-row-gap: 1rem;
}

.option-bar {
  width: 70vw;
}
</style>