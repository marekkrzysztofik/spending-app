<template>
    <div class="m-3">
        <div class="mb-2">
            <Calendar @date-select="changeDate(selectedMonth)" v-model="selectedMonth" view="month" dateFormat="mm-yy"
                placeholder="Wybierz miesiąc" />
        </div>
        <DataTable :value="transactions" paginator :rows="5" :rowsPerPageOptions="[5, 10]" v-model:filters="filters"
            responsiveLayout="scroll" editMode="row" dataKey="id" filterDisplay="row" class="datatable" scrollable>
            <Column header="Nazwa budżetu" filterField="name">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <span>{{ data.name }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Nazwa"
                        class="p-column-filter" style="width: 8rem">

                    </InputText>
                </template>
            </Column>
            <Column header="Nazwa kategori" filterField="category_name">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <span>{{ data.category_name }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Nazwa"
                        class="p-column-filter" style="width: 8rem">

                    </InputText>
                </template>
            </Column>
            <Column header="Tytuł transakcji" filterField="title">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <span>{{ data.title }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" @input="filterCallback()" placeholder="Tytuł"
                        class="p-column-filter" style="width: 8rem">

                    </InputText>
                </template>
            </Column>
            <Column header="Kwota" filterField="amount" style="text-align:right">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <span>{{ data.amount }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <InputText v-model="filterModel.value" type="number" @input="filterCallback()" placeholder="Kwota"
                        class="p-column-filter" style="width: 8rem">
                    </InputText>
                </template>
            </Column>
            <Column header="Data" filterField="date" :showFilterMenu="false" style="min-width: 14rem">
                <template #body="{ data }">
                    <div class="flex align-items-center gap-2">
                        <span>{{ data.date }}</span>
                    </div>
                </template>
                <template #filter="{ filterModel, filterCallback }">
                    <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="months"
                        placeholder="Miesiąc" class="p-column-filter" style="width: 8rem">
                        <template #option="slotProps">
                            <div class="flex align-items-center gap-2">

                                <span>{{ slotProps.option }}</span>
                            </div>
                        </template>
                    </Dropdown>
                </template>
            </Column>
            <template #footer>
                <p>Razem x transakcji w tym miesiącu.</p>
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
const filters = ref({
    date: { value: null, matchMode: FilterMatchMode.CONTAINS },
    title: { value: null, matchMode: FilterMatchMode.CONTAINS },
    amount: { value: null, matchMode: FilterMatchMode.CONTAINS },
    name: { value: null, matchMode: FilterMatchMode.CONTAINS },
    category_name: { value: '', matchMode: FilterMatchMode.CONTAINS },
});
const months = ref(['01-', '02-', '03-', '04-', '05-', '06-', '07-', '08-', '09-', '10-', '11-', '12-'
]);
</script>