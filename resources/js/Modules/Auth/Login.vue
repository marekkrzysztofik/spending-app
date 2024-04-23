<template>
    <Toast position="bottom-right"/>
    <div class="flex flex-column align-items-center m-3">
        <h1 class="">{{ component.title }}</h1>
        <form class="flex flex-column w-max align-items-center m-3" @submit.prevent="submit">
            <div v-for="input in component.columns">
                <input :name="input.name" :type="input.type" :placeholder="input.placeholder" class="input m-2" required />
            </div>
            <button type="submit" class="m-3 button">{{ component.title }}</button>
        </form>
        <p class="text-danger">
            <span>{{ error }} </span>
        </p>
    </div>
</template>
   
<script setup lang="ts">
import { ref, Ref, onMounted } from 'vue';
import axios from "axios";
import { useRouter } from 'vue-router';
import { Column, FormComponent, Form } from '@/types/column'; 
import { components } from '@/consts/loginComponents'
import { useToast } from 'primevue/usetoast'

const toast = useToast()
const props = defineProps({
    id: {
        type: Number,
        default: 0,
    },
});
const router = useRouter();
const error = ref();
const component: Ref<FormComponent> = ref({
    title: '',
    columns: <Column[]>[],
    apiName: ''
})

onMounted(() => {
    component.value = components[props.id]
    console.log(component.value)
});
const submit = (event: Event) => {
    const target: HTMLFormElement = event.target as HTMLFormElement;
    const form = Object.fromEntries(new FormData(target));
    const formData: Form = {
        name: form.name as string,
        surname: form.surname as string,
        email: form.email as string,
        password: form.password as string,
        c_password: form.c_password as string,
    };
    const apiName = component.value?.apiName
    console.log(formData, apiName)
    login(formData, apiName);
};
const login = async (data: Form, path: string = 'login') => {
    await axios.post(`/api/${path}`, data)
        .then(response => {
            const loginResponse = response.data;
            if (loginResponse.success) {
                localStorage.setItem("token", loginResponse.data.token);
                localStorage.setItem("userID", loginResponse.data.id);
                router.push("/home");
            }
        })
        .catch((err) => {
            toast.add({
                severity: 'error',
                summary: 'Try again',
                detail: err.response.data.message,
                life: 3000,
            })
        });
};
</script>
<style>
.text-danger {
    color: red;
    font-size: 16px;
}
</style>