<template>
    <div class=flex>
        <div class="flex flex-column">
            <div @click="get(index)" v-for="(budget, index) in budgets" class="flex m-1 sidemenu-item">
                <Knob v-model="value" :size="50" readonly />
                <div class="ml-2">
                    <h3>{{ budget.name }}</h3>
                    <span>200 zł / {{ budget.amount }} zł</span>
                </div>

            </div>
        </div>
        <div class="flex m-3">
            <h1></h1>
        </div>
    </div>
</template>
<script setup lang="ts">
import { useBudgets } from "@/../utils/useBudgets";
import { onMounted, reactive, ref, Ref } from "vue";
import { useRouter } from "vue-router";

const { getBudgets, budgets } = useBudgets();
const value = ref(40)
onMounted(async () => {
    getBudgets();
});

const get = (id: any) => {
    console.log(budgets.value[id])
}
</script>
<style>

.sidemenu-item:hover {
    background-color: rgba(207, 207, 207);
    cursor: pointer;
}

.sidemenu-item {
    margin: 0.2rem auto;
    padding: 1rem;
    border-radius: 10px;
    transition: color 0.2s ease;
}
</style>