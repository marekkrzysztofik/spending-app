<template>
    <DataTable v-if="transactions.length" :value="transactions" responsiveLayout="scroll" editMode="row" dataKey="id"
        class="datatable">
        <Column field="category_id" header="ID Kategori" sortable/>
        <Column field="title" header="Tytuł transakcji" style="width: 26rem" />
        <Column field="amount" header="Kwota" style="text-align:right">
        </Column>
        <Column field="date" header="Data" />
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

const { getTransactionsByUserId, transactions } = useTransactionsByUserId();
onMounted(() => {
    getTransactionsByUserId(1);
});
</script>