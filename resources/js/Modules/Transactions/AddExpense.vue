<template>
    <div class="input-grid">
        <div>
            <h2>Tytuł </h2>
            <InputText v-model="expenseForm.title" type="text" class="m-3" />
        </div>
        <div>
            <h2>Kwota</h2>
            <InputNumber v-model="expenseForm.amount" placeholder="Price" class="m-3" />
        </div>
        <div>
            <h2>Kategoria</h2>
            <Dropdown v-model="category" :options="categories" optionLabel="category_name" placeholder="Select category"
                class="m-3" />
        </div>
        <div>
            <h2>Data</h2>
            <Calendar v-model="date" dateFormat="dd/mm/yy" class="m-3" />
        </div>
        <Checkbox class="m-3" v-model="expenseForm.type" :binary="true" />
        <Button @click="save" label="Save" class="p-button-rounded m-3 save-btn w-9" />
    </div>
</template>
<script setup lang="ts">
import { reactive, onMounted, ref, defineEmits } from "vue";
import { useCategories } from "@/../utils/useCategories";

import axios from 'axios'

const { getCategories, categories } = useCategories();
const emit = defineEmits(['close-modal']);
const category = ref({
    id: 0,
    category_name: "",
});
const date = ref(new Date());
interface expenseForm {
    date: Date;
    category_id: number;
    title: string;
    amount: number;
    type: boolean;
}
const expenseForm: expenseForm = reactive({
    date: new Date(),
    title: '',
    category_id: 0,
    amount: 0,
    type: false
});
const closeModal = () => {
    emit('close-modal');
};
const save = async () => {
    expenseForm.category_id = category.value.id;
    const data = date.value.toLocaleDateString("af-ZA").replaceAll('/', '-')
    expenseForm.date = data
    console.log(expenseForm)
    await axios
        .post("/api/createTransaction", expenseForm)
        .then(() => {
            closeModal()
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
