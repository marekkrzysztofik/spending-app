import { ref, Ref } from "vue";
import axios from "axios";

interface Transaction {
    id: number;
    user_id: number;
    category_id: number;
    title: string;
    amount: number;
    type: number;
    date: Date;
}
export function useTransactionsByUserId() {
    const transactions: Ref<Array<Transaction>> = ref([]);
    async function getTransactionsByUserId(id: number) {
        const response = await axios.get(`/api/getTransactionsByUserId/${id}`);
        transactions.value = response.data;
    }
    return { getTransactionsByUserId, transactions };
}
