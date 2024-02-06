<template>
    <h1>Login</h1>
    <div>
        <form class="flex flex-column w-max" @submit.prevent="submit">
            <div v-for="input in registerColumns">
                <InputText :name="input.name" :type="input.type" :placeholder="input.placeholder" class="m-2" required />
            </div>
            <Button label="Register" type="submit" class="m-3 p-button-rounded" />
        </form>
        <p class="text-danger">
            <span>{{ error }} </span>
        </p>
    </div>
</template>
  
<script setup lang="ts">
import { ref } from 'vue';
import axios from "axios";
import { useRouter } from 'vue-router';

const router = useRouter();
const error = ref();
const registerColumns: any = [
    { name: "email", type: "email", placeholder: "Email" },
    { name: "password", type: "password", placeholder: "Password" },
    { name: "c_password", type: "password", placeholder: "Confirm Password" }
];

const submit = (event: any) => {
    const form = Object.fromEntries(new FormData(event.target));
    login(form);
};

const login = async (data: any) => {
    console.log(data)
    await axios.post("/api/login", data).then((response) => {
        const loginResponse = response.data;
        if (loginResponse.success) {
            localStorage.setItem("token", loginResponse.data.token);
            localStorage.setItem("userID", loginResponse.data.id);
            router.push("/");
        }
    })
        .catch((e) => {
            error.value = e.response.data.message;
        });
};


</script>
<style>
.text-danger {
    color: red;
    font-size: 16px;
}
</style>