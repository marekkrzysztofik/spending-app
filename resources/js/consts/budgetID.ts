import { reactive, Ref } from "vue";

interface Budget {
    id: number,
    amounts: Array<number>
    sum: number
}
export const budget: Budget = reactive({id:1, amounts:[], sum:0})