<template>
    <form @submit.prevent="onSubmit" class="input-grid">
        <div class="m-auto p-3">
            <h2 class="m-1">Nazwa budżetu</h2>
            <input v-model="budgetForm.name" type="text" placeholder="Nazwa" class="input" required />
        </div>
        <div class="m-auto p-3">
            <h2 class="m-1">Limit wydatków</h2>
            <input v-model.number="budgetForm.limit" inputId="minmaxfraction" :maxFractionDigits="2" placeholder="Limit"
                required class="input" />
        </div>
        <div class="m-auto p-3">
            <h2 class="m-1">Zakres czasowy</h2>
            <Calendar v-model="dates" selectionMode="range" dateFormat="dd/mm/yy" :manualInput="false" placeholder="Data" />
            <p class="p-error" id="date-error">{{ errorMessage || '&nbsp;' }}</p>
        </div>
        <button class="w-min m-3 button" type="submit">Save</button>
    </form>
</template> 
 
<script setup lang="ts">
import axios from "axios";
import { reactive, ref, defineEmits, Ref } from "vue";
import { useRouter } from "vue-router";

interface BudgetForm {
    user_id: number;
    name: string;
    description: string;
    start_date: string;
    end_date: string;
    limit: number;
}
const router = useRouter();
const dates: Ref<Array<Date>> = ref([new Date(), addMonths(new Date(), 1)])
const emit = defineEmits(['close-modal']);
const errorMessage: Ref<string> = ref('')
const budgetForm: BudgetForm = reactive({
    user_id: 1,
    name: '',
    description: 'ss',
    start_date: '',
    end_date: '',
    limit: 0
});
function addMonths(date: Date, months: number) {
    date.setMonth(date.getMonth() + months);
    return date;
}
const closeModal = () => {
    emit('close-modal');
};
const transformDate = () => {
    dates.value.forEach((date: Date, i: number) => {
        if (i == 0) {
            budgetForm.start_date = date.toLocaleDateString("af-ZA").replaceAll('/', '-')
        }
        else budgetForm.end_date = date.toLocaleDateString("af-ZA").replaceAll('/', '-')
    });
}
const onSubmit = () => {
    if (dates.value) {
        transformDate()
        save()
    } else errorMessage.value = 'Wypełnij to pole'
}
const save = async () => {
    await axios
        .post("/api/budgets", budgetForm)
        .then(() => {
            closeModal()
        });
};
</script>
