<template>
  <div class=flex>
    <ScrollPanel style="height: 520px">
      <div class="flex flex-column">
        <div @click="get(index)" v-for="(budget, index) in budgets" class="flex m-1 sidemenu-item">
          <div>
            <button class="btn-icon btn-icon-success"><i class="pi pi-pencil" @click="disabled = false" /></button>
            <button class="btn-icon btn-icon-danger"><i class="pi pi-ban" /></button>
          </div>
          <div class="ml-2">
            <InputText :value="budget.name" class="no-style-input" :disabled="disabled" unstyled />
            <span>{{ budget.categories_sum_category_limit | 0 }} / {{ budget.limit }} zł</span>
          </div>
        </div>
      </div>
    </ScrollPanel>
    <Category @refresh="getBudgets" />
  </div>
</template> 
<script setup lang="ts">
import { useBudgets } from "@/../utils/useBudgets";
import { onMounted } from "vue";
import { budget } from "@/consts/budgetID"
import { ref, Ref } from "vue";

const { getBudgets, budgets } = useBudgets();

onMounted(() => {
  getBudgets();
});
const disabled: Ref<boolean> = ref(true)
const get = (budgetId: number) => {
  budget.id = budgets.value[budgetId].id
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