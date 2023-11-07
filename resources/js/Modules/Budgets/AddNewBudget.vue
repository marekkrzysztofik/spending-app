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
    <ShareBudget/>
</template> 

<script setup lang="ts">
import axios from "axios";
import { onMounted, reactive, ref, Ref, defineEmits } from "vue";
import { useRouter } from "vue-router";
import ShareBudget from "./ShareBudget.vue";
  
const router = useRouter();

const dates = ref()
const se = () => {
    console.log(dates.value)
}
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
        if(i==0) {
            budgetForm.start_date = date.toLocaleDateString("af-ZA").replaceAll('/', '-')
        }
        else budgetForm.end_date = date.toLocaleDateString("af-ZA").replaceAll('/', '-')
    });
}
const save = async () => {
     transformDate()
    await axios
        .post("/api/createBudget", budgetForm)
        .then(() => {
            router.push('/budgets')
        });
};

</script>