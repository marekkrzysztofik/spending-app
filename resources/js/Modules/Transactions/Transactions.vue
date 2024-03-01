<template>
    <div class="m-3">
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
                    <Dropdown v-model="filterModel.value" @change="filterCallback()" :options="months" placeholder="Miesiąc"
                        class="p-column-filter" style="width: 8rem">
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
import { onMounted, ref } from "vue";
import { useTransactionsByUserId } from "@/../utils/useTransactionsByUserId"; 
import { FilterMatchMode } from 'primevue/api';
import { category } from "@/consts/categoryID";

const { getTransactionsByUserId, transactions } = useTransactionsByUserId();
onMounted(() => {
    getTransactionsByUserId();
    filters.value.category_name.value = category.name
});
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