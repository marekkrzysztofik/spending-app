import { ref, Ref } from "vue";
import axios from "axios";

export function useUsers() {
    interface User {
        id: number;
        name: string;
        surname: string;
    }
    const users: Ref<Array<User>> = ref([]);
    async function getUsers() {
        const response = await axios.get(`/api/getUsers`);
        users.value = response.data;
    }
    return { getUsers, users };
}
 