import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Home from "@/Components/Home.vue"
import Transactions from "@/Modules/Transactions/Transactions.vue";
import Register from "@/Modules/Auth/Register.vue";
import Budgets from '@/Modules/Budgets/Budgets.vue'
import Categories from "@/Modules/Categories/Categories.vue"

const routes: Array<RouteRecordRaw> = [
    {
        path: "/",
        component: Home,
        name: "Home",
    },
    {
        path: "/categories",
        component: Categories,
        name: "Categories",
    },
    {
        path: "/register",
        component: Register,
        name: "Register",
    },
    {
        path: "/budgets",
        component: Budgets,
        name: "Budgets",
    },
    {
        path: "/transactions",
        component: Transactions,
        name: "Transactions",
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

// router.beforeEach((to, from) => {
//     if (to.meta.requiresAuth && !localStorage.getItem("token")) {
//         return { name: "Login" };
//     }
//     if (to.meta.requiresAuth == false && localStorage.getItem("token")) {
//         return { name: "/" };
//     }
// });

export default router;
