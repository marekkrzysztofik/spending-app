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
}
export const transactionsColumns: TransactionsColumn[] = [
    { field: 'id', header: 'ID' },
  { field: 'category_name', header: 'Name' },
  { field: 'category_limit', header: 'Style' },
  { field: 'title', header: 'Competition' },
  { field: 'amount', header: 'MinAge' },
  { field: 'type', header: 'MaxAge' },
  { field: 'date', header: 'Start Time' },
];
export function useTransactionsWithCategories() {

    const transactions: Ref<Array<Transaction>> = ref([]);
    async function getTransactionsWithCategories(id: number) {
        const response = await axios.get(`/api/getTransactionsJoinedWithCategoriesByBudgetId/${id}`);
        transactions.value = response.data;
    }
    return { getTransactionsWithCategories, transactions };
}
