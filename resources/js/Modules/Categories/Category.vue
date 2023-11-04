<template>
  <DataTable v-if="categories.length" :value="categories" responsiveLayout="scroll" editMode="row" dataKey="id"
    v-model:editingRows="editingRows" @row-edit-save="onRowEditSave" class="datatable p-4" unstyled>
    <Column field="category_name" header="Nazwa kategori" style="width: 26rem" />
    <Column field="category_limit" header="Zaplanowane" style="text-align:right"> <template #editor="{ data, field }">
        <InputText v-model="data[field]" unstyled />
      </template>
    </Column>
    <Column :rowEditor="true" bodyStyle="text-align:center">
    </Column>
    <Column><template #body="event">
        <button @click="deleteCategory(event.data.id)" class="btn-icon btn-icon-danger">
          <i class="pi pi-ban"></i>
        </button>
      </template>
    </Column>
    <template #footer>
      <p>Razem x transakcji w tym miesiącu.</p>
      <Button class="" icon="pi pi-plus" label="New Category" @click="visible = true" />
    </template>
  </DataTable>
  <Dialog v-model:visible="visible" modal>
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
import { onMounted, reactive, ref, watch, defineEmits } from "vue";
import { useCategoriesByBudgetId } from "@/../utils/useCategoriesByBudgetId";
import { budget } from "@/consts/budgetID";

interface Category {
  category_name: string;
  budget_id: number;
  category_limit: number;
}
const { getCategoriesByBudgetId, categories } = useCategoriesByBudgetId();
const emit = defineEmits(['refresh']);
const editingRows = ref([]);
const categoryForm: Category = reactive({
  category_name: "",
  budget_id: 1,
  category_limit: 0
});
const visible = ref(false);

watch(
  () => budget.id,
  (id) => {
    getCategoriesByBudgetId(id)
    categoryForm.budget_id = id
  }
)
onMounted(async () => {
  await getCategoriesByBudgetId(budget.id);
});
const onRowEditSave = (event: any) => {
  let { newData, index } = event;
  save(newData)
  refreshBudgets()
};
const refreshBudgets = () => {
  emit('refresh');
};
const submit = () => {
  save(categoryForm);
};
const deleteCategory = (id: any) => {
  axios.delete(`/api/deleteCategory/${id}`).then(() => {
    getCategoriesByBudgetId(budget.id);
    refreshBudgets()
  });
};
const save = async (data: Category) => {
  await axios.post("/api/createOrUpdateCategory", data).then(() => {
    visible.value = false;
    getCategoriesByBudgetId(budget.id);
    refreshBudgets()
  });
};
</script>
<style scoped></style>
 