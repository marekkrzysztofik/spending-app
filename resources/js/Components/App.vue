<template>
    <div class="flex">
        <nav class="h-screen border-right-1 border-400 navbar">
            <router-link to="/">
                <h1 class="primary-heading mb-3 text-center">Spending tracker</h1>
            </router-link>
            <div class="sidemenu-item" v-for="(menuItem, index) in menuItems" :key="index">
                <router-link class="sidemenu-link" :to="menuItem.path">
                    <i :class="menuItem.icon" /> {{ menuItem.label }}
                </router-link>
            </div>
            <div @click="newTransaction" class="new-transaction">
                <i class="pi pi-plus m-auto" />
                <p class="m-1-auto">Add transaction</p>
            </div>
        </nav>
        <div>
            <div class="top-panel pl-4 bg-white border-bottom-1 border-400">
                <h2>{{ route.name }}</h2>
                <button @click="logout" class="button logout"><i class="pi pi-sign-out"></i></button>
            </div>
            <div class="">
                <router-view :key="componentKey" />
            </div>
        </div>
    </div>
    <Dialog v-model:visible="visible" modal>
        <AddExpense @close-modal="visible = false; componentKey += 1" />
    </Dialog>
</template>
<script setup lang="ts">
import { ref, onMounted, } from "vue";
import { useRouter, useRoute, RouteRecordName } from "vue-router";
import { usePrimeVue } from "primevue/config";

const visible = ref(false)
const componentKey = ref(0)
const router = useRouter();
const route = useRoute()
const menuItems = [
    { path: "/home", label: "Home", icon: 'pi pi-th-large mr-2' },
    { path: "/budgets", label: "Budgets", icon: 'pi pi-dollar mr-2' },
    { path: "/categories", label: "Categories", icon: 'pi pi-th-large mr-2' },
    { path: "/transactions", label: "Transactions", icon: 'pi pi-wallet mr-2' },
    { path: "/analytics", label: "Analytics", icon: 'pi pi-database mr-2' },
    { path: "/login", label: "Log in", icon: 'pi pi-user mr-2' },
] 
onMounted(() => {
    polishDateFormat();
});
const logout = () => {
    localStorage.removeItem("token");
    localStorage.removeItem("userID");
    router.push("/");
    location.reload();
};
const newTransaction = () => {
    visible.value = true;
}
const polishDateFormat = () => {
    const primevue = usePrimeVue();
    primevue.config.locale.dateFormat = "dd/mm/yy";
}
</script>
<style scoped>


.top-panel {
    display: flex;
    position: relative;
    align-items: center;
    height:10vh;
    width: 85vw;
}

.navbar {
    background-color: white;
    padding: 2.5vh;
    width: 15vw;
}

.new-transaction {
    margin-top: 1rem;
    display: flex;
    border-style: dashed;
    padding: 1.3rem 0;
    border-width: 2px;
    border-color: var(--green);
    flex-direction: column;
    width: 100%;
}

.sidemenu-link {
    color: rgb(153, 153, 153);
    transition: color 0.3s ease-out;
}

.sidemenu-item:hover .sidemenu-link {
    color: black;
}

.sidemenu-item:hover {
    background-color: rgba(207, 207, 207);
}

.sidemenu-item {
    margin: 0.2rem auto;
    width: 95%;
    padding: 0.65rem 1rem;
    border-radius: 10px;
    transition: color 0.2s ease;
}
</style>
