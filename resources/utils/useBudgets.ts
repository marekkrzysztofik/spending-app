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
        limit: number;
        type: string;
        categories_sum_category_limit: number;
        transactions_sum_amount: number;
    }
    const currentDate = new Date(); 
    const month = currentDate.getMonth()+1
    const budgets: Ref<Array<Budget>> = ref([]);
    async function getBudgets() {
        const response = await axios.get(`/api/budgets/1/${month}`);
        budgets.value = response.data;
    }
    return { getBudgets, budgets };
}
  