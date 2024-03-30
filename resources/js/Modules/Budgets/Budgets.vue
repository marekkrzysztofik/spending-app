<template>
  <div class="m-4">
    <div class="flex justify-content-between option-bar">
      <div>
        <button @click="selectComponent(userID)" class="button">Private</button>
        <button @click="selectComponent(1)" class="button ml-3">Common</button>
      </div>
      <h1 v-if="!budgets.length">No budgets</h1>
      <div class="flex-end">
        <Calendar @date-select="changeDate(selectedMonth)" v-model="selectedMonth" view="month" dateFormat="mm-yy"
          placeholder="Wybierz miesiąc" />
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
        <div @click="link(index)" v-for="(budget, index) in budgets" :key="index" class="item-box text-center">
          <div class="">
            <h3>{{ budget.name }}</h3>
            <Chart type="doughnut" :data="budget" class="chart-width" />
            <span>{{ budget.transactions_sum }} / {{ budget.category_limit_sum }} zł</span>
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
import { onMounted, ref } from "vue";
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

onMounted(async () => {
  await getBudgets(getMonth(), getYear(), userID);
}); 
const changeDate = async (date: Date) => {
  await getBudgets(getMonth(date), getYear(date), userID)
}
const selectComponent = async (id: number) => {
  await getBudgets(getMonth(), getYear(), id);
}
const closeModal = (id: number) => {
  selectComponent(id)
  visible.value = false
}
const link = (id: any) => {
  budget.id = budgets.value[id].id
  router.push('/categories')
}
// const prepareDataForCharts = (array: Ref<Array<Budget>>) => {
//   chartData.value = array.value.map((item) => {
//     return {
//       name: item.name,
//       sum: item.categories_sum_category_limit,
//       limit: item.limit,
//       labels: ['A', 'B',],
//       datasets:
//         [
//         {
//           data: [item.transactions_sum_amount, item.categories_sum_category_limit],
//           backgroundColor: ['#E46651', '#41B883']
//         }],
//     };
//   });
// }
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

.option-bar {
  width: 70vw;
}
</style>