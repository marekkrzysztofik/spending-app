<template>
  <DataTable :value="categories" responsiveLayout="scroll" class="datatable p-4" unstyled>
    <Column field="category_name" style="width: 26rem" />
    <Column field="category_limit" header="Zaplanowane" style="text-align:right" />
    <template #footer>
      <p>Razem x transakcji w tym miesiącu.</p>
      <Button icon="pi pi-plus" label="New Category" @click="visible = true" />
    </template>
  </DataTable>
  <Dialog v-model:visible="visible">
    <form class="flex">
      <div>
        <h2>Nazwa kategori</h2>
        <InputText v-model="categoryForm.category_name" type="text" placeholder="Nazwa" class="m-1" />
      </div>
      <div>
        <h2>Limit kategori</h2>
        <InputNumber v-model="categoryForm.category_limit" inputId="minmaxfraction" :maxFractionDigits="2"
          placeholder="Limit" class="m-1" />
      </div>
    </form>
    <Button @click="submit" label="Save" class="m-3" />
  </Dialog>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, reactive, ref, watch } from "vue";
import { useCategoriesByBudgetId } from "@/../utils/useCategoriesByBudgetId";
import { useRouter } from "vue-router";
import { budget } from "@/consts/budgetID";

interface Category {
  category_name: string;
  budget_id: number;
  category_limit: number;
}
const categoryForm: Category = reactive({
  category_name: "",
  budget_id: 1,
  category_limit: 0
});

const { getCategoriesByBudgetId, categories } = useCategoriesByBudgetId();
const visible = ref(false);

watch(
  () => budget.id,
  (id) => {
    getCategoriesByBudgetId(id)
    categoryForm.budget_id = id
  }
)
onMounted(() => {
  getCategoriesByBudgetId(budget.id);
  getCategoriesLimits()
});
const submit = () => {
  save(categoryForm);
};
const getCategoriesLimits = () => {
  categories.value.forEach((category:Category) => {
    budget.amounts.push(category.category_limit)
  });
  console.log(budget.amounts)
}
const save = async (data: Category) => {
  await axios.post("/api/createOrUpdateCategory", data).then(() => {
    visible.value = false;
    getCategoriesByBudgetId(budget.id);
  });
};
</script>
<style scoped></style>
