<template>
  <ConfirmDialog />
  <div class="flex flex-column m-4">
    <Calendar @date-select="changeDate(selectedMonth)" v-model="selectedMonth" class="w-2" view="month" dateFormat="mm-yy"
      placeholder="Wybierz miesiąc" />
    <ScrollPanel style="height: 520px;" class="m-3">
      <div v-for="(budget, index) in budgetsWithCategories" class="flex justify-content-between sidemenu-item"
        :class=budget.class>
        <div class="flex align-items-center ml-2">
          <div class="">
            <h3>{{ budget.name }}</h3>
            <span>{{ budget.categories_sum_category_limit | 0 }} / {{ budget.limit }} zł</span>
            <div class="flex">
              <button @click="editBudgetVisible = true" class="btn-icon btn-icon-success"><i
                  class="pi pi-pencil" /></button>
              <button @click="confirmDialog(deleteBudget, budget.id)" class="btn-icon btn-icon-danger"><i
                  class="pi pi-ban" /></button>
            </div>
          </div>
          <div class="flex flex-column">
            <DataTable :value="budget.categories" responsiveLayout="scroll" editMode="row" dataKey="id"
              v-model:editingRows="editingRows" @row-edit-save="onRowEditSave" class="datatable p-4">
              <Column field="category_name" header="Nazwa kategori" style="min-width: 15rem;max-width: 15rem;"
                class="no-overflow" />
              <Column field="" header="Wydane" />
              <Column field="category_limit" header="Zaplanowane" style="text-align:right"> <template
                  #editor="{ data, field }">
                  <InputText v-model="data[field]" />
                </template>
              </Column>
              <Column :rowEditor="true" bodyStyle="text-align:center">
              </Column>
              <Column><template #body="event">
                  <button @click="confirmDialog(deleteCategory, event.data.id)" class="btn-icon btn-icon-danger">
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
            </DataTable>
            <button class="ml-5 w-3 button" @click="manageModal(index, budget.start_date)" unstyled>New Category</button>
          </div>
        </div>
        <Dialog v-model:visible="newCategoryVisible" modal>
          <AddNewCategory @refresh="getBudgetsWithCategories(); newCategoryVisible = false" :id=budget.id />
        </Dialog>
        <Dialog v-model:visible="editBudgetVisible" modal>
          <EditBudget @refresh="getBudgetsWithCategories(); editBudgetVisible = false" :id=budget.id />
        </Dialog>
      </div>
    </ScrollPanel>
  </div>
</template> 
<script setup lang="ts">
import axios from "axios";
import { useBudgets } from "@/../utils/useBudgets";
import { onMounted, ref, Ref } from "vue";
import { budget } from "@/consts/budgetID"
import { useRouter } from "vue-router";
import EditBudget from '@/Modules/Budgets/EditBudget.vue'
import { useDate } from "@/../utils/useDate";
import { useConfirm } from "primevue/useconfirm";
import ConfirmDialog from "primevue/confirmdialog";
import { useToast } from "primevue/usetoast";
import { useSaveCategory } from "../../../utils/useSaveCategory";
import { category } from "@/consts/categoryID";
import AddNewCategory from "./AddNewCategory.vue";

const selectedMonth = ref()
const router = useRouter();
const editBudgetVisible = ref(false)
const newCategoryVisible = ref(false)
const { getBudgets, budgets } = useBudgets();
const { getMonth, getYear } = useDate()
const confirm = useConfirm();

const toast = useToast()
const { saveCategory, categoryForm } = useSaveCategory();
onMounted(async () => {
  await getBudgetsWithCategories()
  //budget.id = budgets.value[0].id
});

const editingRows = ref([]);
const onRowEditSave = (event: any) => {
  let { newData } = event;
  saveCategory(newData)
  getBudgetsWithCategories()
};
const budgetsWithCategories = ref()
const getBudgetsWithCategories = async () => {
  const response = await axios.get(`/api/budgets`)
  budgetsWithCategories.value = response.data
  console.log(budgetsWithCategories.value)
}
const getTransactions = (name: string) => {
  category.name = name
  router.push('/transactions')
}

const deleteBudget = (id: any) => {
  axios.delete(`/api/budgets/${id}`).then(() => {
    getBudgetsWithCategories()
  });
}
const deleteCategory = (id: any) => {
  axios.delete(`/api/deleteCategory/${id}`).then(() => {
    getBudgetsWithCategories()
  });
};
const changeDate = async (date: any) => {
  await getBudgets(getMonth(date), getYear(date));
  budget.id = budgets.value[0].id

}
const manageModal = (id: any, date: any) => {
  console.log(id)
  if (budgetsWithCategories.value[id].categories.length == 0) {
    newCategoryVisible.value = true
  } else {
    const categoryDate = new Date(date)
    const currentMonth = new Date().getMonth()
    const currentYear = new Date().getFullYear()
    const newCategoryAvailibilityDate = new Date(currentYear, currentMonth)
    if (categoryDate.getTime() < newCategoryAvailibilityDate.getTime()) {
      toast.add({ severity: 'warn', summary: 'Uwaga!', detail: 'Nie możesz dodać kategori do archiwalnych budżetów', life: 5000 });
    } else {
      newCategoryVisible.value = true
    }
  }
}
const confirmDialog = (callback: any, id: any) => {
  confirm.require({
    message: "Do you want to delete this competitor?",
    header: "Delete Confirmation",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      toast.add({
        severity: "info",
        summary: "Confirmed",
        detail: "Budget deleted",
        life: 3000,
      });
      callback(id);
    },
    reject: () => {
      toast.add({
        severity: "error",
        summary: "Rejected",
        detail: "You have rejected",
        life: 3000,
      });
    },
  });
};
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
  width: 100%;
  align-items: center;
  background-color: white;
  color: rgb(95, 95, 95);
  margin: 0.2rem auto;
  padding: 1rem;
  border-radius: 10px;
  transition: color 0.2s ease;
}
</style>