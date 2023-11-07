import { ref, Ref } from "vue";
import axios from "axios";

interface Transaction {
    id: number;
    user_id: number;
    category_id: number;
    title: string;
    amount: number;
    type: number;
    date: string;
}
function formatDate(inputDate:string) {
    const parts = inputDate.split("-");
      const formattedDate = parts[2] + "-" + parts[1] + "-" + parts[0];
      return formattedDate;
  }
export function useTransactionsByUserId() {
    const transactions: Ref<Array<Transaction>> = ref([]);
    async function getTransactionsByUserId(id: number) {
        const response = await axios.get(`/api/getTransactionsByUserId/${id}`);
        transactions.value = response.data;
        transactions.value.forEach(el => {
            el.date = formatDate(el.date)
        });
    }
    return { getTransactionsByUserId, transactions };
}
