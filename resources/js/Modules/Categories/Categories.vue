<template>
  <ConfirmDialog />
  <Toast/>
  <div class="flex flex-column align-items-center mvt-1">
    <ScrollPanel style="height: 83vh; width:82vw">
      <div class="grid">
        <div v-for="budget in budgetsWithCategories" class="sidemenu-item" :class=budget.class>
          <div class="flex align-items-center justify-content-between v-1">
            <div class="budget-label">
              <h3>{{ budget.name }}</h3>
              <span class="ml-2">{{ budget.categories_sum }} / {{ budget.categories.reduce((sum:any, category:any) => {
                return sum + Number(category.category_limit);
            }, 0) }} zł</span>
            </div>
            <div class="flex">
              <button @click="manageBudgetId(budget.id); editBudgetVisible = true" class="button m-1"><i
                  class="pi pi-pencil" /></button>
              <button @click="confirmDialog(deleteBudget, budget.id)" class="button m-1"><i
                  class="pi pi-ban" /></button>
              <button class="button m-1" @click="manageBudgetId(budget.id); newCategoryVisible = true">New
                Category</button>
            </div>
          </div>
          <div class="v-0-1">
            <DataTable v-if="budget.categories.length > 0" :value="budget.categories" :scrollable="true"
              scrollHeight="20vh" size="small" editMode="row" dataKey="id" v-model:editingRows="editingRows"
              @row-edit-save="onRowEditSave" class="datatable">
              <Column field="category_name" header="Category name" style="width: 10rem;" class="no-overflow" />
              <Column field="transactions_sum" header="Spent" />
              <Column field="category_limit" header="Planned"> <template #editor="{ data, field }">
                  <InputText v-model="data[field]" style="width:3rem;padding:0;" />
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
          </div>
        </div>
      </div>

    </ScrollPanel>
    <Dialog v-model:visible="newCategoryVisible" modal>
      <AddNewCategory @refresh="getBudgetsWithCategories(); newCategoryVisible = false" :id="currentBudgetId" />
    </Dialog>
    <Dialog v-model:visible="editBudgetVisible" modal>
      <EditBudget @refresh="getBudgetsWithCategories(); editBudgetVisible = false;" :id="currentBudgetId" />
    </Dialog>
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
import { userID } from "@/../utils/userID";

const { getBudgets, budgets } = useBudgets();
const { saveCategory } = useSaveCategory();
const { getMonth, getYear } = useDate()
const router = useRouter();
const confirm = useConfirm();
const toast = useToast()
const editBudgetVisible = ref(false)
const newCategoryVisible = ref(false)
const currentBudgetId: Ref<number> = ref(0)
const budgetsWithCategories = ref()
const editingRows = ref([]);

onMounted(async () => {
  await getBudgetsWithCategories()
});

const onRowEditSave = (event: any) => {
  let { newData } = event;
  saveCategory(newData)
  getBudgetsWithCategories()
};
const getBudgetsWithCategories = async () => {
  const response = await axios.get(`/api/getBudgetsForCategoriesComponent/${userID}`)
  budgetsWithCategories.value = response.data
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

const manageBudgetId = (id: any) => {
  currentBudgetId.value = id
}
const manageModal = (budget: any, id: any) => {
  // newCategoryBudgetId.value = budget.id;
  if (budgetsWithCategories.value[id].categories.length == 0) {
    newCategoryVisible.value = true
  } else {
    const categoryDate = new Date(budget.start_date)
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
    message: "Do you want to delete this record?",
    header: "Delete Confirmation",
    icon: "pi pi-info-circle",
    acceptClass: "p-button-danger",
    accept: () => {
      toast.add({
        severity: "info",
        summary: "Confirmed",
        detail: "Record deleted",
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
  color: black;
}

.grid {
  margin: auto;
  display: grid;
  grid-template-columns: repeat(2, 40vw);
  grid-template-rows: 1fr;
  grid-column-gap: 1.5vw;
  grid-row-gap: 1vw;
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
  min-height: 20vh;
}

.sidemenu-item {
  background-color: white;
  color: rgb(95, 95, 95);
  border-radius: 10px;
  transition: color 0.2s ease;
}
</style>