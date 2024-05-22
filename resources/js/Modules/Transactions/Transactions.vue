<template>
    <div class="m-3">
        <DataTable :value="transactions" paginator :rows="5" :rowsPerPageOptions="[5, 10]" v-model:filters="filters"
            responsiveLayout="scroll" editMode="row" dataKey="id" filterDisplay="row" class="datatable" scrollable
            scrollHeight="80vh" size="small">
            <Column header="Budget Name" filterField="name">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <span>{{ data.name }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Name"
                        class="p-column-filter" style="width: 8rem">

                    </InputText>
                </template>
            </Column>
            <Column header="Category Name" filterField="category_name">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <span>{{ data.category_name }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Name"
                        class="p-column-filter" style="width: 8rem">

                    </InputText>
                </template>
            </Column>
            <Column header="Title" filterField="title">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <span>{{ data.title }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Title"
                        class="p-column-filter" style="width: 8rem">

                    </InputText>
                </template>
            </Column>
            <Column header="Amount" filterField="amount" style="text-align:right">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <span>{{ data.amount }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="number" @input="filterCallback()"
                        class="p-column-filter" style="width: 4rem">
                    </InputText>
                </template>
            </Column>
            <Column header="Date" filterField="date" :showFilterMenu="false" style="min-width: 14rem">
                <template #filter>
                    <Calendar @date-select="changeDate(selectedMonth)" v-model="selectedMonth" view="month"
                        dateFormat="mm-yy" />
                </template>
                <template #body="{ data }">

                    <div class="flex align-items-center gap-2">
                        <span>{{ data.date }}</span>
                    </div>
                </template>
            </Column>
            <template #footer>
                <p>Razem {{ transactions.length }} transakcji w tym miesiącu.</p>
            </template>
        </DataTable>
    </div>
</template>
<script setup lang="ts">
import { onMounted, ref, Ref } from "vue";
import { FilterMatchMode } from 'primevue/api';
import { category } from "@/consts/categoryID";
import axios from "axios";
import { userID } from "@/../utils/userID"
import { useDate } from "@/../utils/useDate";

interface Transaction {
    id: number;
    category_name: string;
    title: string;
    amount: number;
    type: number;
    date: string;
}
const selectedMonth = ref()
const transactions: Ref<Array<Transaction>> = ref([]);
const { getMonth, getYear } = useDate();
const filters = ref({
    date: { value: null, matchMode: FilterMatchMode.CONTAINS },
    title: { value: null, matchMode: FilterMatchMode.CONTAINS },
    amount: { value: null, matchMode: FilterMatchMode.CONTAINS },
    name: { value: null, matchMode: FilterMatchMode.CONTAINS },
    category_name: { value: '', matchMode: FilterMatchMode.CONTAINS },
});
onMounted(() => {
    getTransactionsByUserId();
    filters.value.category_name.value = category.name
});
function formatDate(inputDate: string) {
    const parts = inputDate.split("-");
    const formattedDate = parts[2] + "-" + parts[1] + "-" + parts[0];
    return formattedDate;
}
async function getTransactionsByUserId(month: any = getMonth(), year: any = getYear()) {
    const response = await axios.get(`/api/getTransactionsJoinedWithCategoriesAndBudgetsByUserId/${userID}/${month}/${year}`);
    transactions.value = response.data;
    transactions.value.forEach(el => {
        el.date = formatDate(el.date)
    });
}
const changeDate = async (date: Date) => {
    await getTransactionsByUserId(getMonth(date), getYear(date))
}
</script>