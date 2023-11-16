<template>
  <h1 v-if="!sharedBudgets.length">No budgets</h1>
  <Button label="private" @click="selectComponent(0)"></Button>
  <Button label="shared" @click="selectComponent(1)"></Button>
  <ScrollPanel style="width: 100%; height: 70vh">
    <div class="grid">
      <div class="m-1 item-box">
        <div class="ml-2">
          <h3>{{ selectedComponent.title }}</h3>
          <div @click="visible = true" :class=selectedComponent.class>
            <i :class=selectedComponent.icon />
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
    <component :is="selectedComponent.name" @close-modal="closeModal"></component>
  </Dialog>
</template>
<script setup lang="ts">
import { useSharedBudgets } from "../../../utils/useSharedBudgets";
import { useBudgets } from "@/../utils/useBudgets";
import { onMounted, ref, Ref, reactive } from "vue";
import { useRouter } from "vue-router";
import { Budget } from "@/types/budget";
import { budget } from "@/consts/budgetID"
import ShareBudget from "./ShareBudget.vue";
import AddNewBudget from "./AddNewBudget.vue";

const router = useRouter();
const { getBudgets, budgets } = useBudgets();
const { getSharedBudgets, sharedBudgets } = useSharedBudgets();
const chartData = ref()
const visible = ref(false)

onMounted(async () => {
  await getSharedBudgets();
  await getBudgets();
  selectComponent(0)
});
const selectedComponent = ref({
  name: AddNewBudget,
  title: 'Add new budget',
  class: 'new-budget',
  icon: 'pi pi-plus m-auto',
  data: budgets
})
const components: Array<any> = [{
  name: AddNewBudget,
  title: 'Add new budget',
  class: 'new-budget',
  icon: 'pi pi-plus m-auto',
  data: budgets
},
{
  name: ShareBudget,
  title: 'Share budget',
  class: 'new-budget',
  icon: 'pi pi-link m-auto',
  data: sharedBudgets
}
]
const selectComponent = (id: number) => {
  selectedComponent.value = components[id]
  prepareDataForCharts(components[id].data)
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
  await getSharedBudgets();
  await getBudgets();
  selectComponent(0)
  visible.value = false
}
const link = (id: any) => {
  // budget.id = budgets.value[id].id
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