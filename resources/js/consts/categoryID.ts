import { reactive , ref ,Ref} from "vue";

interface Category {
    name: string;
}
export const category: Category = reactive({name:''}) 