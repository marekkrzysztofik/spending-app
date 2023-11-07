<template>
    <DataTable :value="transactions" v-model:filters="filters" responsiveLayout="scroll" editMode="row" dataKey="id"
        filterDisplay="row" class="datatable">
        <Column field="category_id" header="ID Kategori" sortable />
        <Column field="title" header="Tytuł transakcji" style="width: 26rem" />
        <Column field="amount" header="Kwota" style="text-align:right">
        </Column>
        <Column header="Data" filterField="date" :showFilterMenu="false"
            style="min-width: 14rem">
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
</template>

<script setup lang="ts">
import axios from "axios";
import { onMounted, reactive, ref, Ref, defineEmits } from "vue";
import { useRouter } from "vue-router";
import { useTransactionsByUserId } from "@/../utils/useTransactionsByUserId";
import { FilterMatchMode } from 'primevue/api';

const { getTransactionsByUserId, transactions } = useTransactionsByUserId();
onMounted(() => {
    getTransactionsByUserId(1);
});
const filters = ref({
    date: { value: null, matchMode: FilterMatchMode.CONTAINS },
});
const months = ref(['01-', '02-','03-','04-','05-','06-','07-','08-','09-', '10-', '11-','12-'
]);
</script> 