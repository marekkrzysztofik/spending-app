import { reactive } from "vue";
import { useDate } from "@/../utils/useDate";
interface Budget {
    id: number
    month: number
    year: number
}
const { getMonth, getYear } = useDate();

export const budget: Budget = reactive({
    id: 1,
    month: getMonth(), year: getYear()
})  
