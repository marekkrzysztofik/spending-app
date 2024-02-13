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
            <h2 class="m-1">Miesiąc</h2>
            <Calendar v-model="date" view="month" dateFormat="mm-yy" :manualInput="false" placeholder="Miesiąc" />
            <p class="p-error" id="date-error">{{ errorMessage || '&nbsp;' }}</p>
        </div>
        <div class="flex p-3 align-items-center">
            <Checkbox v-model="shared" :binary="true" />
            <h2 class="m-2">Udostępnij</h2>
        </div>
        <button class="w-min m-3 button" type="submit">Save</button>
    </form>
</template> 
 
<script setup lang="ts">
import axios from "axios";
import { reactive, ref, defineEmits, Ref } from "vue";
import { useRouter } from "vue-router";
import { userID } from "@/../utils/userID";

interface BudgetForm {
    user_id: number;
    name: string;
    start_date: string;
    end_date: string;
    limit: number;
}
const router = useRouter();
const date: Ref<any> = ref()
const shared: Ref<boolean> = ref(false)
const emit = defineEmits(['close-modal']);
const errorMessage: Ref<string> = ref('')
const budgetForm: BudgetForm = reactive({
    user_id: userID,
    name: '',
    start_date: '',
    end_date: '',
    limit: 0
});
function addMonths(date: Date, months: number) {
    date.setMonth(date.getMonth() + months);
    return date;
}
const closeModal = () => {
    emit('close-modal', budgetForm.user_id);
};
const transformDate = (date: Date) => {
    const transformedDate = date.toLocaleDateString("af-ZA").split('/').join('-')
    return transformedDate
}
const onSubmit = () => {
    if (date.value) {
        budgetForm.start_date = transformDate(date.value)
        budgetForm.end_date = transformDate(addMonths(date.value, 1))
        if (shared.value) {
            budgetForm.user_id = 1
        }
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
