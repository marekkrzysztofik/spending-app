<template>
    <div class="input-grid">
        <div>
            <InputNumber v-model="expenseForm.price" placeholder="Price" class="m-3" />
            <InputText type="number" placeholder="Description" class="m-3" />
        </div>
        <div>
            <Dropdown v-model="category" :options="categories" optionLabel="name" placeholder="Select category"
                class="m-3" />
            <Calendar v-model="date" dateFormat="yy/mm/dd" class="m-3" />
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
    name: "",
});
const date = ref(new Date());
interface expenseForm {
    day: number;
    month: number;
    year: number;
    category_id: number;
    price: number;
}
const expenseForm: expenseForm = reactive({
    day: 0,
    month: 0,
    year: 0,
    category_id: 0,
    price: 0,
});

const save = async () => {
    expenseForm.category_id = category.value.id;
    // expenseForm.year = dateConverter(new Date(expenseForm.year));
    const data = dateConverter(new Date(date.value));
    expenseForm.year = parseInt(data.slice(0, 4));
    expenseForm.month = parseInt(data.slice(5, 7));
    expenseForm.day = parseInt(data.slice(8, 10));
    console.log(data, expenseForm);
    await axios
        .post("/api/createExpense", expenseForm)
        .then(() => {
            console.log("gitówa")
        });
};
onMounted(() => {
    // newDate();
    // expenseForm.year = currentDate.getFullYear();
    getCategories();
    //  expenseForm.year = new Date(expenseForm.day, expenseForm.month,2023);
});
// const newDate = () => {
//     const currentDate = new Date();
//    // expenseForm.year = dateConverter(currentDate);
//     expenseForm.month = currentDate.getMonth() + 2;
//     expenseForm.day = currentDate.getDate();
// };
const dateConverter = (date: any) => {
    console.log(date.toDateString())
    return date.toISOString().split("T")[0];
};

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
