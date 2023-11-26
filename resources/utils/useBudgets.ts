import { ref, Ref } from "vue";
import axios from "axios";
import { Budget } from "@/types/budget";


export function useBudgets() {
    const currentDate = new Date();
    const month = currentDate.getMonth() + 1
    const budgets: Ref<Array<Budget>> = ref([]);
    async function getBudgets() {
        const response = await axios.get(`/api/budgets/1/${month}`);
        budgets.value = response.data;
    }
    return { getBudgets, budgets };
}
