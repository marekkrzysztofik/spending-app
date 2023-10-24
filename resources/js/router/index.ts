import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import Home from "@/Components/Home.vue"
import Categories from "@/Components/Categories.vue"
import AddExpense from "@/Components/AddExpense.vue";
import Register from "@/Components/Register.vue";
import Budgets from '@/Modules/Budgets.vue'
import Category from "@/Components/Category.vue";

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
