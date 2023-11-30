<template>
    <div class="m-5">
        <Checkbox v-model="income" :binary="true" class="mr-2" />
        <span>Income</span>
    </div>
    <form @submit.prevent="onSubmit" class="input-grid">
        <div>
            <h2>Tytuł </h2>
            <input v-model="expenseForm.title" type="text" class="m-3 input" required />
        </div>
        <div>
            <h2>Kwota</h2>
            <input v-model="expenseForm.amount" placeholder="Price" class="m-3 input" required />
        </div>
        <div>
            <h2>Data</h2>
            <Calendar v-model="date" dateFormat="dd/mm/yy" class="m-3" />
        </div>
        <div>
            <h2 v-if="!income">Kategoria</h2>
            <CascadeSelect v-if="!income" v-model="category" :options="categories" optionLabel="category_name" optionGroupLabel="name"
            :optionGroupChildren="['categories']" class="m-3" style="minwidth: 14rem"/>
            <p v-if="errorMessage" class="p-error" id="date-error">{{ errorMessage || '&nbsp;' }}</p>
        </div>
        <Button type="submit" label="Save" class="p-button-rounded m-3 save-btn w-9" />
    </form>
</template>
<script setup lang="ts">
import { reactive, onMounted, ref, defineEmits, Ref } from "vue";
import { useCategories } from "@/../utils/useCategories";

import axios from 'axios'


const { getCategories, categories } = useCategories();
const emit = defineEmits(['close-modal']);
const category = ref();
const errorMessage: Ref<string> = ref('')
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
   // getCategories();
    getBudgetsWithCategories()
});
const getBudgetsWithCategories = async () => {
    const response = await axios.get(`/api/budgets`)
    categories.value = response.data;
}
const closeModal = () => {
    emit('close-modal');
};
const onSubmit = () => {
    if (category.value || income.value && !category.value) {
        save()
    } else errorMessage.value = 'Wypełnij to pole'

}
const save = async () => {
    console.log(category.value)
    // expenseForm.category_id = category.value.id;
    // expenseForm.budget_id = category.value.budget_id;
    // const data = date.value.toLocaleDateString("af-ZA").replaceAll('/', '-')
    // expenseForm.date = data
    // console.log(expenseForm)
    // await axios
    //     .post("/api/createTransaction", expenseForm)
    //     .then(() => {
    //         closeModal()
    //     });
};


</script>

