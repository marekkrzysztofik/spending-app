<template>
  <h1 class="m-3">Dodaj nową kategorię</h1>
  <div class="flex justify-content-center">
      <div class="flex justify-content-center">
          <form class="flex">
              <div class="m-3 pad-20 br-radius-20 bg-white flex">
                  <div class="m-3">
                      <h2>Kategorie wydatków</h2>
                      <div>
                          <div
                              v-for="item in categories"
                              class="flex align-items-center"
                          >
                              <p>{{ item.name }}</p>
                              <button
                                  @click=""
                                  class="btn-icon btn-icon-danger m-2"
                              >
                                  <i class="pi pi-ban"></i>
                              </button>
                          </div>
                      </div>
                  </div>
                  <div class="m-3">
                      <h2>Dodaj nową kategorie</h2>
                      <InputText
                          v-model="categoryForm.name"
                          type="text"
                          placeholder="Nazwa"
                          class="m-3"
                      />
                      <Button @click="submit" label="Save" class="m-3" />
                  </div>
              </div>
          </form>
      </div>
  </div>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, reactive, ref, Ref } from "vue";
import { useRouter } from "vue-router";
import { useCategories } from "@/../utils/useCompetitors";
const router = useRouter();

const { getCategories, categories } = useCategories();


interface Category {
  name: string;
}


const categoryForm: Category = reactive({
  name: "",
});

onMounted(async () => {
  getCategories();
});

const submit = () => {
  capitilizeString(categoryForm.name);
  save(categoryForm);
};
const capitilizeString = (str: string) => {
  const firstLetter = str.charAt(0).toUpperCase();
  const restOfString = str.slice(1).toLowerCase();
  categoryForm.name = firstLetter + restOfString;
};
const save = async (data: Category) => {
  await axios.post("/api/createCategory", data).then(() => {
      getCategories();
  });
};
</script>
<style scoped></style>
