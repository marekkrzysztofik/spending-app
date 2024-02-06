import { ref, Ref } from "vue";
import axios from "axios";
import { Budget } from "@/types/budget";
import { useDate } from "@/../utils/useDate";

const { getMonth, getYear } = useDate();

export function useBudgets() {
    const budgets: Ref<Array<Budget>> = ref([]);
    async function getBudgets(month: any = getMonth(), year: any = getYear(), id:any) {
        const response = await axios.get(`/api/getBudgetsByUserId/${id}/${month}/${year}`);
         budgets.value = response.data;
    }
    return { getBudgets, budgets };
}
