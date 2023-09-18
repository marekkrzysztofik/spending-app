<template>
    <div class="flex">
        <nav class="h-screen p-4 bg-white border-right-1 border-300 navbar">
            <router-link to="/">
                <h1 class="primary-heading mb-3">Spending tracker</h1>
            </router-link>
            <div class="sidemenu-item" v-for="(menuItem, index) in menuItems" :key="index">
                <router-link class="sidemenu-link" :to="menuItem.path">
                    <i :class="menuItem.icon" /> {{ menuItem.label }}
                </router-link>
            </div>
            <div class="new-transaction">
                <Button class="add-button m-auto" icon="pi pi-plus" unstyled />
                <router-link to="/add-expense" class="m-1-auto">
                    <p>Add transaction</p>
                </router-link>
            </div>
        </nav>
        <div>
            <div class="top-panel pl-4 bg-white">
                <h2>Dashboard</h2>
            </div>
            <div class="m-4">
                <router-view />
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const menuItems = [
    { path: "/", label: "Home", icon: 'pi pi-th-large mr-2' },
    { path: "/categories", label: "Categories", icon: 'pi pi-th-large mr-2' },
    { path: "/budgets", label: "Budgets", icon: 'pi pi-dollar mr-2' },
    { path: "/goals", label: "Goals", icon: 'pi pi-check-circle mr-2' },
    { path: "/goals", label: "Analytics", icon: 'pi pi-database mr-2' },
    { path: "/goals", label: "Settings", icon: 'pi pi-cog mr-2' },
]
</script>
<style scoped>
li {
    list-style-type: none;
}

a {
    color: black;
    text-decoration: none;
}

.top-panel {
    display: flex;
    align-items: center;
    background-color: aquamarine;
    height: 5rem;
    width: 85vw;
}

.navbar {
    width: 15vw;
}

.new-transaction {
    margin-top: 1rem;
    display: flex;
    border-style: dashed;
    padding: 1.3rem 0;
    border-width: 2px;
    border-color: rgba(0, 119, 6, 0.3);
    flex-direction: column;
    justify-content: center;
    width: 100%;
}

.add-button {
    border: none;
    border-radius: 50%;
    height: 3rem;
    width: 3rem;
    background-color: rgba(0, 119, 6, 0.7);

}

.nav-bar:last-child {
    align-items: flex-end;
}

.sidemenu-link {
    color: rgb(153, 153, 153);
    transition: color 0.2s ease;
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
