import { ref, Ref } from "vue";
import axios from "axios";
import { Budget } from "@/types/budget";


export function useBudgets() {
    const budgets: Ref<Array<Budget>> = ref([]);
    async function getBudgets(month:any) {
        const response = await axios.get(`/api/getBudgetsByUserId/1/${month}`); 
        budgets.value = response.data;
    }
    return { getBudgets, budgets };
}
