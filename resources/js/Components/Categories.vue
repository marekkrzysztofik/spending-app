<template>
  <h1 v-if="!budgets.length">No budgets</h1>

  <ScrollPanel style="width: 100%; height: 70vh">
    <div class="grid">
      <div class="m-1 item-box">
        <div class="ml-2">
          <h3>Add new budget</h3>
          <Button class="m-2 w-10" icon="pi pi-plus" size="large"></Button>
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
</template>
<script setup lang="ts">
import axios from "axios";
import { useCategories } from "@/../utils/useCategories";
import { useBudgets } from "@/../utils/useBudgets";
import { onMounted, ref, defineEmits } from "vue";
import { useRouter } from "vue-router";
import { budget } from "@/consts/budgetID"

const router = useRouter();
const { getBudgets, budgets } = useBudgets();
const chartData = ref()
const options = ref()

onMounted(async () => {
  await getBudgets();
  chartData.value = budgets.value.map((item) => {
    return {
      name: item.name,
      sum: item.categories_sum_category_limit,
      limit: item.limit,
      datasets:
        [{
          data: [item.categories_sum_category_limit, item.limit],
          backgroundColor: ['#E46651', '#41B883']
        }],
    };
  });
});
const link = (id: any) => {
  budget.id = budgets.value[id].id
  router.push('/budgets')
}

</script>
<style scoped>
.chart-width {
  width: 8rem;
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
