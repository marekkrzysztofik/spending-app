import { ref, Ref } from "vue";
import axios from "axios";

export function useCategoriesByBudgetId() {
    interface Category {
        category_name: string;
        budget_id: number;
        category_limit: number;
    }
    const categories: Ref<Array<Category>> = ref([]);
    async function getCategoriesByBudgetId(id:number) {
        const response = await axios.get(`/api/getCategoriesByBudgetId/${id}`);
        categories.value = response.data;
    }
    return { getCategoriesByBudgetId, categories };
}
