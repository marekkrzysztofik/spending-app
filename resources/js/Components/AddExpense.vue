<template>
    <div class="input-grid">
        <div>
            <InputNumber v-model="expenseForm.price" placeholder="Price" class="m-3" />
            <InputText type="number" placeholder="Description" class="m-3" />
        </div>
        <div>
            <Dropdown v-model="category" :options="categories" optionLabel="category_name" placeholder="Select category"
                class="m-3" />
            <Calendar v-model="date" dateFormat="dd/mm/yy" class="m-3" />
        </div>
        <Button @click="save" label="Save" class="p-button-rounded m-3 save-btn w-9" />
    </div>
</template>
<script setup lang="ts">
import { reactive, onMounted, ref, Ref } from "vue";
import { useCategories } from "@/../utils/useCategories";

import axios from 'axios'

const { getCategories, categories } = useCategories();

const category = ref({
    id: 0,
    category_name: "",
});
const date = ref(new Date());
interface expenseForm {
    date: Date;
    category_id: number;
    price: number;
}
const expenseForm: expenseForm = reactive({
    date: new Date(),
    category_id: 0,
    price: 0,
});

const save = async () => {
    expenseForm.category_id = category.value.id;
    const data = date.value.toLocaleDateString("af-ZA").replaceAll('/', '-')
    expenseForm.date = data
    console.log(data, expenseForm);
    await axios
        .post("/api/createExpense", expenseForm)
        .then(() => {
            console.log("gitówa")
        });
};
onMounted(() => {
    getCategories();
});

</script>
<style scoped>
.input-grid {
    margin: auto;
    display: grid;
    align-items: center;
    grid-template-columns: repeat(2, 250px);
    grid-template-rows: repeat(2, 1fr);
    grid-column-gap: 0px;
    grid-row-gap: 0px;
}
</style>
