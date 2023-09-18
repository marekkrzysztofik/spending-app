<template>
    <div class="flex">
        <nav>
            <div class="flex flex-column header__nav">
                <router-link to="/">
                    <h1 class="primary-heading mb-3">Spending tracker</h1>
                </router-link>
                <nav class="flex flex-column">
                    <div class="sidemenu-item" v-for="(menuItem, index) in menuItems" :key="index">
                        <router-link class="sidemenu-link" :to="menuItem.path">
                            <i :class="menuItem.icon" /> {{ menuItem.label }}
                        </router-link>
                    </div>
                </nav>
            </div>
        </nav>
        <router-view />
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

.header__nav {
    margin: 2rem;
}
</style>
