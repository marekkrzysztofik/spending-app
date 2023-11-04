import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Home from "@/Components/Home.vue"
import AddExpense from "@/Modules/Transactions/AddExpense.vue";
import Register from "@/Modules/Auth/Register.vue";
import Budgets from '@/Modules/Budgets/Budgets.vue'
import Categories from "@/Modules/Categories/Categories.vue"
import Category from "@/Modules/Categories/Category.vue";

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
        path: "/add-expense",
        component: AddExpense,
        name: "AddExpense",
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
        path: "/category",
        component: Category,  
        name: "Category",
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
