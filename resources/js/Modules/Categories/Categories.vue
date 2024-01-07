<template>
  <div class=flex>
    <ScrollPanel style="height: 520px">
      <div class="flex flex-column">
        <div @click="get(index)" v-for="(budget, index) in budgets" class="flex m-1 sidemenu-item">
          <div>
            <button @click="visible = true" class="btn-icon btn-icon-success"><i class="pi pi-pencil" /></button>
          </div>
          <div class="ml-2">
            <h3>{{ budget.name }}</h3>
            <span>{{ budget.categories_sum_category_limit | 0 }} / {{ budget.limit }} zł</span>
          </div>
        </div>
      </div>
    </ScrollPanel>
    <Calendar @date-select="changeDate(selectedMonth)" v-model="selectedMonth" class="month-picker" view="month"
      dateFormat="mm-yy" placeholder="Wybierz miesiąc" />
    <div class="">
      <Category @refresh="getBudgets" />
    </div>
  </div>
  <Dialog v-model:visible="visible" modal>
    <EditBudget @refresh="closeModal" />
  </Dialog>
</template> 
<script setup lang="ts">
import { useBudgets } from "@/../utils/useBudgets";
import { onMounted, ref } from "vue";
import { budget } from "@/consts/budgetID"
import { useRouter } from "vue-router";
import EditBudget from '@/Modules/Budgets/EditBudget.vue'
import { useDate } from "@/../utils/useDate";

const selectedMonth = ref()
const router = useRouter();
const visible = ref(false)
const { getBudgets, budgets } = useBudgets();
const { getMonth, getYear } = useDate()
onMounted(async () => {
  getBudgets(budget.month, budget.year);
  budget.id = budgets.value[0].id
});
const get = (arrayId: number) => {
  budget.id = budgets.value[arrayId].id
}
const closeModal = () => {
  getBudgets(getMonth, getYear)
  visible.value = false
}
const changeDate = async (date: any) => {
  await getBudgets(getMonth(date), getYear(date));
  budget.id = budgets.value[0].id
}
</script>
<style scoped>
.sidemenu-item:hover {
  background-color: rgba(207, 207, 207);
  color: black;
  cursor: pointer;
}

.month-picker {
  position: absolute;
  right: 20%;
}

.hidden {
  display: none;
}

.animation {
  transition: all 0.7s ease;
}

.datatable {
  background-color: white;
  border-radius: 10px;
}

.sidemenu-item {
  align-items: center;
  background-color: white;
  color: rgb(95, 95, 95);
  margin: 0.2rem auto;
  padding: 1rem;
  border-radius: 10px;
  transition: color 0.2s ease;
}
</style>