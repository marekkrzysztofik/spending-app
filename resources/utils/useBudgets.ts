import { ref, Ref } from "vue";
import axios from "axios";
import { Budget } from "@/types/budget";
import { BudgetForm } from "@/types/budgetForm";
import { budget } from "@/consts/budgetID";

export function useBudgets() {
    const budgetForm: Ref<BudgetForm> = ref({
        id: 0,
        name: '',
        limit: 0
    })
    const currentDate = new Date();
    const month = currentDate.getMonth() + 1
    const budgets: Ref<Array<Budget>> = ref([]);
    async function getBudgets() {
        const response = await axios.get(`/api/budgets/1/${month}`);
        budgets.value = response.data;
        budgetForm.value = response.data[budget.id - 1]
    }
    return { getBudgets, budgets, budgetForm };
}
