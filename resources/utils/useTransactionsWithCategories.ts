import { ref, Ref } from "vue";
import axios from "axios";

interface Transaction {
    id: number;
    budget_id: number;
    category_name: string;
    category_limit: string;
    category_id: number;
    title: string;
    amount: number;
    type: string;
    date: Date;
}
interface TransactionsColumn {
    field: string;
    header: string;
    style: string;
}
export const transactionsColumns: TransactionsColumn[] = [
    { field: 'id', header: 'ID', style:"min-width: 2rem; color: blue;" },
  { field: 'title', header: 'Tytuł', style:"width: 10rem" },
  { field: 'amount', header: 'Kwota', style:"width: 3.5rem" },
  { field: 'date', header: 'Data transakcji', style:"width: 7.5rem" },
];
export function useTransactionsWithCategories() {

    const transactions: Ref<Array<Transaction>> = ref([]);
    async function getTransactionsByCategoryId(id: number) {
        const response = await axios.get(`/api/getTransactionsByCategoryId/${id}`);
        transactions.value = response.data;
    }
    return { getTransactionsByCategoryId, transactions };
}
