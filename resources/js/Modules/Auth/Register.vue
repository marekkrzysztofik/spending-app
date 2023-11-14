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
import { registerColumns } from '@/consts/registerColumns.ts'

const router = useRouter();

const submit = (event: any) => {
  const form = Object.fromEntries(new FormData(event.target));
  register(form);
};

const register = async (data: any) => {
  console.log(data)
  await axios.post("/api/register", data).then(() => {
    router.push("/");
  });
};

const errors = ref([]);

</script>
<style>
.text-danger {
  color: red;
  font-size: 16px;
}
</style>