<template>
  <h1 class="m-3">Dodaj nową kategorię</h1>
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
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, reactive, ref, Ref, defineProps, defineEmits } from "vue";
import { useRouter } from "vue-router";
import { useCategories } from "@/../utils/useCategories";
const router = useRouter();

const { getCategories, categories } = useCategories();
const value = ref()
const { isModalOpen } = defineProps(['isModalOpen']);
const emit = defineEmits(['close-modal']);
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
  getCategories();
});
const submit = () => {
  save(categoryForm);
};
const closeModalFromChild = () => {
  emit('close-modal');
};
const save = async (data: Category) => {
  await axios.post("/api/createCategory", data).then(() => {
    closeModalFromChild()
  });
};

const capitilizeString = (str: string) => {
  const firstLetter = str.charAt(0).toUpperCase();
  const restOfString = str.slice(1).toLowerCase();
  categoryForm.name = firstLetter + restOfString;
};

</script>
<style scoped></style>
