import { ref, Ref } from "vue";
import axios from "axios";
import { Budget } from "@/types/budget";
import { useDate } from "@/../utils/useDate";

const { getMonth, getYear } = useDate();
const userID = localStorage.getItem('userID')
export function useBudgets() {
    const budgets: Ref<Array<Budget>> = ref([]);
    async function getBudgets(month: any = getMonth(), year: any = getYear(), id: any = userID) {
        const response = await axios.get(`/api/getDataForBudgetsComponent/${id}/${month}/${year}`);
        budgets.value = response.data;
    }
    return { getBudgets, budgets };
}
 