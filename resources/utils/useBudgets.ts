import { ref, Ref } from "vue";
import axios from "axios";
import { Budget } from "@/types/budget";
import { budget } from "@/consts/budgetID";

export function useBudgets() {
    const budgets: Ref<Array<Budget>> = ref([]);
    async function getBudgets(month: any=budget.month, year: any=budget.year) {
        const response = await axios.get(`/api/getBudgetsByUserId/1/${month}/${year}`);
        budgets.value = response.data;
    }
    return { getBudgets, budgets };
}
