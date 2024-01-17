<template>
    <form @submit.prevent="onSubmit" class="input-grid">

        <div>
            <h2>Tytuł </h2>
            <input v-model="expenseForm.title" type="text" class="m-3 input" required />
        </div>
        <div> 
            <h2>Kwota</h2>
            <input v-model.number="expenseForm.amount" placeholder="Price" class="m-3 input" required />
        </div>
        <div>
            <h2>Data</h2>
            <Calendar v-model="date" dateFormat="dd/mm/yy" class="m-3" />
        </div>
        <div>
            <h2 v-if="!income">Kategoria</h2>
            <CascadeSelect v-if="!income" v-model="category" :options="categories" optionLabel="category_name"
                optionGroupLabel="name" :optionGroupChildren="['categories']" class="m-3" style="minwidth: 14rem" />
            <p v-if="errorMessage" class="p-error" id="date-error">{{ errorMessage || '&nbsp;' }}</p>
        </div>
        <div>
            <h2>Przychód</h2>
            <div>
                <Checkbox v-model="income" :binary="true" class="m-3" />
            </div>
        </div>
        <div>
            <Button type="submit" label="Save" class="m-3 save-btn w-10" />
        </div>
    </form>
</template>
<script setup lang="ts">
import { reactive, onMounted, ref, defineEmits, Ref } from "vue";
import { useCategories } from "@/../utils/useCategories";
import axios from 'axios'

interface expenseForm {
    date: Date;
    title: string;
    amount: number;
}
const { categories } = useCategories();
const emit = defineEmits(['close-modal']);
const category = ref();
const errorMessage: Ref<string> = ref('')
const income: Ref<boolean> = ref(false);
const date = ref(new Date());
const expenseForm: any = reactive({ 
    date: new Date(),
    title: '',
    amount: 0,
});
onMounted(() => {
    getBudgetsWithCategories()
});
const getBudgetsWithCategories = async () => {
    const response = await axios.get(`/api/budgets`)
    categories.value = response.data.filter((item: any) => item.categories.length > 0);
}
const closeModal = () => {
    emit('close-modal');
};
const onSubmit = () => {
    if (category.value || income.value && !category.value) {
        manageSave()
    } else errorMessage.value = 'Wypełnij to pole'

}
const manageSave = async () => {
    const data = date.value.toLocaleDateString("af-ZA").replaceAll('/', '-')
    expenseForm.date = data
    expenseForm.user_id = 1;
    if (income.value) {
        save('createIncome')
    } else {
        expenseForm.category_id = category.value.id;
        expenseForm.budget_id = category.value.budget_id;
        save('createTransaction')
    }
};
const save = async (path: string) => {
    await axios
        .post(`/api/${path}`, expenseForm)
        .then(() => {
            closeModal()
        });
}
</script>
