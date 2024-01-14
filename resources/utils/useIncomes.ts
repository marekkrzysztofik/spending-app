import { ref, Ref } from "vue";
import axios from "axios";

export function useIncomes() {
    interface Income {
        id: number;
        user_id: number;
        title: string;
        date: Date;
        amount: number;
    }
    const currentDate = new Date();
    const month = currentDate.getMonth() + 1
    const incomes: Ref<Array<Income>> = ref([]);
    async function getIncomes() {
        const response = await axios.get(`/api/getIncomesByUserId/1/${month}`);
        incomes.value = response.data;
    }
    return { getIncomes, incomes };
}
 