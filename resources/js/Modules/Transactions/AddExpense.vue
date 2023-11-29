<template>
    <div class="m-5">
        <Checkbox v-model="income" :binary="true" class="mr-2" />
        <span>Income</span>
    </div>
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
            <Dropdown v-if="!income" v-model="category" :options="categories" optionLabel="category_name"
                placeholder="Select category" class="m-3" />
        </div>
        <div>
            <h2>Data</h2>
            <Calendar v-model="date" dateFormat="dd/mm/yy" class="m-3" />
        </div>
        <Button @click="save" label="Save" class="p-button-rounded m-3 save-btn w-9" />
    </div>
</template>
<script setup lang="ts">
import { reactive, onMounted, ref, defineEmits, Ref } from "vue";
import { useCategories } from "@/../utils/useCategories";
import { useForm } from 'vee-validate';

import axios from 'axios'

const { defineInputBinds, errors, handleSubmit } = useForm();
const { getCategories, categories } = useCategories();
const emit = defineEmits(['close-modal']);
const category = ref();
const income: Ref<boolean> = ref(false);
const date = ref(new Date());
interface expenseForm {
    budget_id: number;
    date: Date;
    category_id: number;
    title: string;
    amount: number;
    type: boolean;
}
const expenseForm: expenseForm = reactive({
    budget_id: 1,
    date: new Date(),
    title: '',
    category_id: 0,
    amount: 0,
    type: false
});
onMounted(() => {
    getCategories();
});
const closeModal = () => {
    emit('close-modal');
};
const save = async () => {
    expenseForm.category_id = category.value.id;
    expenseForm.budget_id = category.value.budget_id;
    const data = date.value.toLocaleDateString("af-ZA").replaceAll('/', '-')
    expenseForm.date = data
    console.log(expenseForm)
    await axios
        .post("/api/createTransaction", expenseForm)
        .then(() => {
            closeModal()
        });
};


</script>

