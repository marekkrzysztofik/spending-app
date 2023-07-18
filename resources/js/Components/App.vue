<template>
    <nav>
        <div class="flex header__nav">
            <div class="flex align-items-center">
                <router-link to="/"
                    ><h1 class="">Spending tracker</h1></router-link
                >
            </div>
            <nav class="flex align-items-center">
                <ul class="flex">
                    <li class="m-2">
                        <router-link to="/">Home</router-link>
                    </li>
                    <li class="m-2">
                        <router-link to="/categories">Categories</router-link>
                    </li>
                </ul>
            </nav>
        </div>
    </nav> 
    <router-view />
</template>
<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
</script>
<style scoped>
li {
    list-style-type: none;
}
a {
    color: black;
    text-decoration: none;
}
.header__nav {
    margin: 0 auto;
    padding: 0 2rem;
    justify-content: center;
    width: 100%;
    align-items: center;
}
</style>
