import { reactive, ref ,Ref } from "vue";

interface Budget {
    id: number
}
export const budget: Budget = reactive({id:1})  