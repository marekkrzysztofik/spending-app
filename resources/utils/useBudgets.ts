import { ref, Ref } from "vue";
import axios from "axios";
import { Budget } from "@/types/budget";


export function useBudgets() {
    const budgets: Ref<Array<Budget>> = ref([]);
    async function getBudgets(month: any, year: any) {
        const response = await axios.get(`/api/getBudgetsByUserId/1/${month}/${year}`);
        budgets.value = response.data;
    }
    return { getBudgets, budgets };
}
