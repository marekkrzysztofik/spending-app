<template>
  <Toast />
  <div>
    <button class="ml-5 button" @click="manageModal" unstyled>New Category</button>
    <DataTable v-if="categories.length" :value="categories" responsiveLayout="scroll" editMode="row" dataKey="id"
      v-model:editingRows="editingRows" @row-edit-save="onRowEditSave" class="datatable p-4">
      <Column field="category_name" header="Nazwa kategori" style="width: 26rem" />
      <Column field="transactions_sum_amount" header="Wydane" />
      <Column field="category_limit" header="Zaplanowane" style="text-align:right"> <template #editor="{ data, field }">
          <InputText v-model="data[field]" />
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
      <Column><template #body="event">
          <button @click="getTransactions(event.data.category_name)" class="btn-icon btn-icon-danger">
            <i class="pi pi-plus"></i>
          </button>
        </template>
      </Column>
      <template #footer>
        <p>Razem x transakcji w tym miesiącu.</p>
      </template>
    </DataTable>
  </div>
  <Dialog v-model:visible="visible" modal>
    <AddNewCategory @close-modal="refreshBudgets" />
  </Dialog>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, ref, watch, defineEmits } from "vue";
import { useCategoriesByBudgetId } from "@/../utils/useCategoriesByBudgetId";
import { budget } from "@/consts/budgetID";
import { category } from "@/consts/categoryID";
import { useRouter } from "vue-router";
import { useSaveCategory } from "../../../utils/useSaveCategory";
import { useToast } from "primevue/usetoast";

const toast = useToast();
const { getCategoriesByBudgetId, categories } = useCategoriesByBudgetId();
const { saveCategory, categoryForm } = useSaveCategory();
const emit = defineEmits(['refresh']);
const editingRows = ref([]);
const router = useRouter()
const visible = ref(false);

watch(
  () => budget.id,
  (id) => {
    //categoryForm.budget_id = id
    getCategoriesByBudgetId(id)
  }
)
onMounted(async () => {
  await getCategoriesByBudgetId(budget.id);
});
const manageModal = () => {
  if (categories.value.length == 0) {
    visible.value = true
  } else {
    const categoryDate = new Date(categories.value[0].created_at.slice(0, 10))
    const currentMonth = new Date().getMonth()
    const currentYear = new Date().getFullYear()
    const newCategoryAvailibilityDate = new Date(currentYear, currentMonth)
    if (categoryDate.getTime() < newCategoryAvailibilityDate.getTime()) {
      toast.add({ severity: 'warn', summary: 'Uwaga!', detail: 'Nie możesz dodać kategori do archiwalnych budżetów', life: 5000 });
    } else {
      visible.value = true
    }
  }
}
const onRowEditSave = (event: any) => {
  let { newData } = event;
  saveCategory(newData)
  refreshBudgets()
};
const refreshBudgets = () => {
  visible.value = false;
  getCategoriesByBudgetId(budget.id);
  emit('refresh');

};
const deleteCategory = (id: any) => {
  axios.delete(`/api/deleteCategory/${id}`).then(() => {
    refreshBudgets()
  });
};
const getTransactions = (name: string) => {
  category.name = name
  router.push('/transactions')
}
</script>
<style scoped></style>
 