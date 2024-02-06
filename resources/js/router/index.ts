import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Home from "@/Components/Home.vue"
import Transactions from "@/Modules/Transactions/Transactions.vue";
import Register from "@/Modules/Auth/Register.vue";
import Login from "@/Modules/Auth/Login.vue";
import Budgets from '@/Modules/Budgets/Budgets.vue'
import Categories from "@/Modules/Categories/Categories.vue"
import EditBudget from '@/Modules/Budgets/EditBudget.vue'

const routes: Array<RouteRecordRaw> = [
    {
        path: "/",
        component: Home,
        name: "Home",
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/categories",
        component: Categories,
        name: "Categories",
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/login",
        component: Login,
        name: "Login",
        meta: {
            requiresAuth: false,
        },
    },
    {
        path: "/register",
        component: Register,
        name: "Register",
        meta: {
            requiresAuth: false,
        },
    },
    {
        path: "/budgets",
        component: Budgets,
        name: "Budgets",
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/transactions",
        component: Transactions,
        name: "Transactions",
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: "/budget/:id",
        component: EditBudget,
        name: "EditBudget",
        props: true,
        meta: {
            requiresAuth: true,
        },
    }
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to,) => {
    if (to.meta.requiresAuth && !localStorage.getItem("token")) {
        return { name: "Login" };
    }
    if (to.meta.requiresAuth == false && localStorage.getItem("token")) {
        return { name: "Home" };
    }
});

export default router;
