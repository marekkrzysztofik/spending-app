<template>
    <div class="flex flex-column align-items-center m-5">
        <h1>Create your account or log in to continue</h1>
        <div class="mt-5">
                <button @click="setID(0)" class="button mx-2">Login</button>
                <button @click="setID(1)" class="button mx-2">Register</button>
        </div>
        <Login  :id="0"/>
        <Login  :id="1"/>
    </div> 
</template>
<script setup lang="ts">
import { ref } from "vue";
import { useRouter, useRoute, RouteRecordName } from "vue-router";
import { usePrimeVue } from "primevue/config";
const router = useRouter()
const componentID = ref()
const visible = ref(false)
const setID = (id:number) => {
    componentID.value = null
    componentID.value=id
    visible.value=true
}
</script>