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
    <div class="flex justify-content-center">
      <div class="flex justify-content-center">
        <form class="flex">
          <div class="m-3 pad-20 br-radius-20 bg-white">
            <div class="m-3 flex">
              <div>
                <h2>Nazwa kategori</h2>
                <InputText v-model="categoryForm.category_name" type="text" placeholder="Nazwa" class="m-3" />
              </div>
              <div>
                <h2>Nazwa kategori</h2>
                <InputNumber v-model="categoryForm.category_limit" inputId="minmaxfraction" :maxFractionDigits="2"
                  placeholder="Limit" class="m-3" />
              </div>
            </div>
            <div>
              <Button @click="submit" label="Save" class="m-3" />
            </div>
          </div>

        </form>
      </div>
    </div>
  </Dialog>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, reactive, ref, Ref, defineProps, defineEmits } from "vue";
import { useCategoriesByBudgetId } from "@/../utils/useCategoriesByBudgetId";
import { useRouter } from "vue-router";
import { useCategories } from "@/../utils/useCategories";
const router = useRouter();
const props = defineProps({
  id: {
    type: Number,
    default: "",
  },
});
const { getCategoriesByBudgetId, categories } = useCategoriesByBudgetId();
const value = ref()
const visible = ref(false);
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

onMounted(async () => {
  getCategoriesByBudgetId(props.id);
});
const submit = () => {
  save(categoryForm);
};
const save = async (data: Category) => {
  await axios.post("/api/createCategory", data).then(() => {
    visible.value = false;
    getCategoriesByBudgetId(props.id);
  });
};
</script>
<style scoped></style>
