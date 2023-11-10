import { ref, Ref } from "vue";
import axios from "axios";

export function useSharedBudgets() {
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
    }
    const sharedBudgets: Ref<Array<Budget>> = ref([]);
    async function getSharedBudgets() {
        const response = await axios.get(`/api/getSharedBudget/2`);
        sharedBudgets.value = response.data;
    }
    return { getSharedBudgets, sharedBudgets };
}
 