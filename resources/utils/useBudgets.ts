import { ref, Ref } from "vue";
import axios from "axios";

export function useBudgets() {
    interface Budget {
        id: number;
        name: string;
        description: string;
        start_date: Date;
        end_date: Date;
        amount: number;
        type: string;
    }
    const budgets: Ref<Array<Budget>> = ref([]);
    async function getBudgets() {
        const response = await axios.get(`/api/getBudgetsByUserId/1/10`);
        budgets.value = response.data;
    }
    return { getBudgets, budgets };
}