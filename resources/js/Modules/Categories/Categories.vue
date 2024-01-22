<template>
  <div class="flex m-3">
    <ScrollPanel style="height: 520px; width:17%">
      <div class="flex flex-column">
        <div v-for="(budget, index) in budgetsWithClasses" class="flex m-1 sidemenu-item" :class=budget.class>
          <div>
            <button @click="visible = true" class="btn-icon btn-icon-success"><i class="pi pi-pencil" /></button>
            <button @click="deleteBudget(index)" class="btn-icon btn-icon-danger"><i class="pi pi-ban" /></button>
          </div>
          <div @click="get(index)" class="ml-2">
            <h3>{{ budget.name }}</h3>
            <span>{{ budget.categories_sum_category_limit | 0 }} / {{ budget.limit }} zł</span>
          </div>
        </div>
      </div>
    </ScrollPanel>
    <Calendar @date-select="changeDate(selectedMonth)" v-model="selectedMonth" class="month-picker" view="month"
      dateFormat="mm-yy" placeholder="Wybierz miesiąc" />
    <div class="">
      <Category @refresh="getBudgets()" />
    </div>
  </div>
  <Dialog v-model:visible="visible" modal>
    <EditBudget @refresh="closeModal" />
  </Dialog>
</template> 
<script setup lang="ts">
import axios from "axios";
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
const budgetsWithClasses = ref()
onMounted(() => {
  prepareData();
  //budget.id = budgets.value[0].id
});
const prepareData = async () => {
  await getBudgets();
  addClassesToBudgets()
}
const get = (arrayId: number) => {
  addClassesToBudgets()
  budget.id = budgets.value[arrayId].id
  budgetsWithClasses.value[arrayId].class = 'active'
  console.log(budgetsWithClasses.value)
}
const addClassesToBudgets = () => {
  budgetsWithClasses.value = budgets.value.map(x => {
    return {
      ...x, class: ''
    }
  })
}
const closeModal = async () => {
  await getBudgets()
  visible.value = false
}
const deleteBudget = (arrayId: any) => {
  const budgetId = budgetsWithClasses.value[arrayId].id
  axios.delete(`/api/budgets/${budgetId}`).then(() => {
    prepareData()
  });
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

.active {
  background-color: rgba(207, 207, 207) !important;
  color: black !important;
}

.month-picker {
  position: absolute;
  right: 20%;
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