import { reactive, ref ,Ref } from "vue";

interface Budget {
    id: number
    month: number
    year:number 
}
export const budget: Budget = reactive({id:1,
month:1,year:2023
})  
