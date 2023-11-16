<template>
  <h1 v-if="!budgets.length">Nowy miesiąc? Nowe budżety, nowy plan</h1>
  <ScrollPanel style="width: 100%; height: 70vh">
    <div class="grid">
      <div class="m-1 item-box">
        <div class="">
          <h3>Add new budget</h3>
          <div @click="visible = true" class="new-budget">
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
</template>
<script setup lang="ts">
import { useBudgets } from "@/../utils/useBudgets";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";
import { budget } from "@/consts/budgetID"
import AddNewBudget from "./AddNewBudget.vue";

const router = useRouter();
const { getBudgets, budgets } = useBudgets();
const chartData = ref()
const visible = ref(false)

onMounted(async () => {
  await getBudgets();
  prepareDataForCharts();
});
const prepareDataForCharts = () => {
  chartData.value = budgets.value.map((item) => {
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
  await getBudgets();
  prepareDataForCharts()
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
  margin-top: 1rem;
  display: flex;
  padding: 1.3rem 0;
  background-color: rgb(65, 184, 131)
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
}

.grid {
  display: grid;
  align-items: center;
  grid-template-columns: repeat(4, 1fr);
  grid-template-rows: repeat(2, 35vh);
  grid-column-gap: 1rem;
  grid-row-gap: 1rem;
}
</style>