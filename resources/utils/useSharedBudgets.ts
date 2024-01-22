import { ref, Ref } from "vue";
import axios from "axios";
import { Budget } from "@/types/budget";

export function useSharedBudgets() {
    const sharedBudgets: Ref<Array<Budget>> = ref([]);
    async function getSharedBudgets() {
        const response = await axios.get(`/api/getSharedBudget/1`);
        sharedBudgets.value = response.data;
    }
    return { getSharedBudgets, sharedBudgets };
}
   