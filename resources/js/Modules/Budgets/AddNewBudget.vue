<template>
    <form class="flex">
        <div>
            <h2>Nazwa budżetu</h2>
            <InputText v-model="budgetForm.name" type="text" placeholder="Nazwa" class="m-1" />
        </div>
        <div>
            <h2>Limit wydatków</h2>
            <InputNumber v-model="budgetForm.limit" inputId="minmaxfraction" :maxFractionDigits="2" placeholder="Limit"
                class="m-1" />
        </div>
        <div>
            <Calendar v-model="dates" selectionMode="range" dateFormat="dd/mm/yy" :manualInput="false" />
        </div>
        <button type="button" @click="save"></button>
    </form>
</template> 

<script setup lang="ts">
import axios from "axios";
import { reactive, ref, defineEmits } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const dates = ref()
const emit = defineEmits(['close-modal']);

const closeModal = () => {
    emit('close-modal');
};
interface BudgetForm {
    user_id: number;
    name: string;
    description: string;
    start_date: string;
    end_date: string;
    limit: number;
}
const budgetForm: BudgetForm = reactive({
    user_id: 1,
    name: '',
    description: 'ss',
    start_date: '',
    end_date: '',
    limit: 0
});
const transformDate = () => {
    dates.value.forEach((date: any, i: number) => {
        if (i == 0) {
            budgetForm.start_date = date.toLocaleDateString("af-ZA").replaceAll('/', '-')
        }
        else budgetForm.end_date = date.toLocaleDateString("af-ZA").replaceAll('/', '-')
    });
}
const currentDate = new Date();
const month = currentDate.getMonth()
const save = async () => {
    transformDate()
    await axios
        .post("/api/createBudget", budgetForm)
        .then(() => {
            closeModal()
        });
};

</script>