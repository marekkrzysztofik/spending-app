<template>
    <h1 class="m-3">Strona główna</h1>
    <div class="grid-box">
        <div v-for="item in expenses" class="flex">
            <div class="p-20">{{ item.name }}</div>
            <div class="p-20">{{ item.price }}</div>
        </div>
    </div>
</template>
<script setup lang="ts">
import axios from "axios";
import { onMounted, reactive, ref, Ref } from "vue";
import { useRouter } from "vue-router";
import { useCategories } from "@/../utils/useCompetitors";
const router = useRouter();

const { getCategories, categories } = useCategories();

onMounted(async () => {
    const currentDate = new Date();
    const currentMonth: number = currentDate.getMonth() + 2;
    getExpensesByMonth(currentMonth);
    getCategories();
});
const expenses = ref([]);
const getExpensesByMonth = async (currentMonth: number) => {
    const response = await axios.get(
        `/api/getExpensesJoinedWithCategoriesByMonth/${currentMonth}`
    );
    expenses.value = response.data;
};
</script>
<style scoped>
.p-20 {
    padding: 20px;
}
</style>
