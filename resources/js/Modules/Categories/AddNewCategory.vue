<template>
    <form @submit.prevent="onSubmit" class="input-grid">
        <div>
            <h2>Nazwa kategori</h2>
            <input v-model="categoryForm.category_name" type="text" placeholder="Nazwa" class="m-1 input" required />
        </div>
        <div>
            <h2>Limit kategori</h2>
            <input v-model.number="categoryForm.category_limit" inputId="minmaxfraction" :maxFractionDigits="2"
                placeholder="Limit" class="m-1 input" required />
        </div>
        <Button type="submit" label="Save" class="m-3" />
    </form>
</template> 
 
<script setup lang="ts">
import { defineEmits } from "vue";
import { useSaveCategory } from "../../../utils/useSaveCategory";

const { saveCategory, categoryForm } = useSaveCategory();
const emit = defineEmits(['close-modal']);

const closeModal = () => {
    emit('close-modal');
};
const onSubmit = () => {
    saveCategory(categoryForm);
    closeModal()
};
</script>
<style scoped></style>
  