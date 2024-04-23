<template>
  <h1>Create your account</h1>
  <div>
    <form class="flex flex-column w-max" @submit.prevent="submit">
      <div v-for="input in registerColumns">
        <InputText :name="input.name" :type="input.type" :placeholder="input.placeholder" class="m-2" required />
      </div>
      <Button label="Register" type="submit" class="m-3 p-button-rounded" />
    </form>
    <p class="text-danger" v-for="error in errors" :key="error">
      <span v-for="err in error" :key="err">{{ err }} </span>
    </p>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import axios from "axios";
import { useRouter } from 'vue-router';
import { Column } from '@/types/column';

const errors = ref([]);
const router = useRouter(); 
const registerColumns: Column[] = [
  { name: "name", type: "text", placeholder: "Name" },
  { name: "surname", type: "text", placeholder: "Surname" },
  { name: "email", type: "email", placeholder: "Email" },
  { name: "password", type: "password", placeholder: "Password" },
  { name: "c_password", type: "password", placeholder: "Confirm Password" }
];
const submit = (event: Event) => {
  const target: HTMLFormElement = event.target as HTMLFormElement;
  const form = Object.fromEntries(new FormData(target));
  const columnData: Column = {
        name: form.name as string,
        placeholder: form.placeholder as string,
        type: form.type as string,
    };
  register(columnData);
};
const register = async (data: Column) => {
  await axios.post("/api/register", data).then(() => {
    router.push("/login");
  });
};
</script>
<style>
.text-danger {
  color: red;
  font-size: 16px;
}
</style>