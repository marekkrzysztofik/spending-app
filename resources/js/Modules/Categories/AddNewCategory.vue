<template>
    <form class="flex">
        <div>
            <h2>Nazwa kategori</h2>
            <InputText v-model="categoryForm.category_name" type="text" placeholder="Nazwa" class="m-1" />
        </div>
        <div>
            <h2>Limit kategori</h2>
            <InputNumber v-model="categoryForm.category_limit" inputId="minmaxfraction" :maxFractionDigits="2"
                placeholder="Limit" class="m-1" />
        </div>
    </form>
    <Button @click="submit" label="Save" class="m-3" />
</template> 

<script setup lang="ts">
import { defineEmits } from "vue";
import { useSaveCategory } from "../../../utils/useSaveCategory";

const { saveCategory, categoryForm } = useSaveCategory();
const emit = defineEmits(['close-modal']);

const closeModal = () => {
    emit('close-modal');
};
const submit = () => {
    saveCategory(categoryForm);
    closeModal()
};
</script>
<style scoped></style>
 