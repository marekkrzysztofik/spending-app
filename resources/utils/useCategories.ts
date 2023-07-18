import { ref, Ref } from "vue";
import axios from "axios";

export function useCategories() {
    interface Category {
        name: string;
    }
    const categories: Ref<Array<Category>> = ref([]);
    async function getCategories() {
        const response = await axios.get(`/api/getCategories`);
        categories.value = response.data;
    }
    return { getCategories, categories };
}
