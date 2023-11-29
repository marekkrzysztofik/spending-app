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
    <Category @refresh="getBudgets" />
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

const router = useRouter();
const visible = ref(false)
const { getBudgets, budgets } = useBudgets();
onMounted(async () => {
  await getBudgets();
});
const get = (arrayId: number) => {
  budget.id = budgets.value[arrayId].id
}
const closeModal = () => {
  getBudgets()
  visible.value = false
}
</script>
<style scoped>
.sidemenu-item:hover {
  background-color: rgba(207, 207, 207);
  color: black;
  cursor: pointer;
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