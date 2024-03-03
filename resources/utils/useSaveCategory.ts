import { reactive } from "vue";
import axios from "axios";
import { budget } from "@/consts/budgetID";

export function useSaveCategory() {
    interface Category {
        category_name: string;
        budget_id: number;
    }
    const categoryForm: Category = reactive({
        category_name: "",
        budget_id: 1,
    });
    async function saveCategory(data: Category, id: number = 0) {
        categoryForm.budget_id = id
        await axios.post("/api/createOrUpdateCategory", data)
    }
    return { categoryForm, saveCategory };
}
