import { ref, reactive } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

export function useSaveCategory() {
    const router = useRouter();
    interface Category {
        category_name: string;
        budget_id: number;
        category_limit: number;
    }
    const categoryForm: Category = reactive({
        category_name: "",
        budget_id: 1,
        category_limit: 0
    });
    async function saveCategory(data: Category) {
        await axios.post("/api/createOrUpdateCategory", data).then(() => {

        });
    }
    return { categoryForm, saveCategory };
}
