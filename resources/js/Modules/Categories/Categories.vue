<template>
  <div class=flex>
      <ScrollPanel style="height: 520px">
          <div class="flex flex-column">
              <div @click="get(index)" v-for="(budget, index) in budgets" class="flex m-1 sidemenu-item">
                  <div class="ml-2">
                      <h3>{{ budget.name }}</h3>
                      <span>{{ budget.categories_sum_category_limit }} / {{ budget.limit }} zł</span>
                  </div>
              </div>
          </div>
      </ScrollPanel>
      <Category @refresh="getBudgets" /> 
  </div>
</template> 
<script setup lang="ts">
import { useBudgets } from "@/../utils/useBudgets";
import { onMounted, ref, watch } from "vue";
import { useRouter } from "vue-router";
import { budget } from "@/consts/budgetID"

const { getBudgets, budgets } = useBudgets();
const value = ref(40)

onMounted(() => {
  getBudgets();
});
const get = (id: any) => {
  budget.id = budgets.value[id].id
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
  background-color: white;
  color: rgb(95, 95, 95);
  margin: 0.2rem auto;
  padding: 1rem;
  border-radius: 10px;
  transition: color 0.2s ease;
}
</style>