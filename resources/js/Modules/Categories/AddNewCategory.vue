<template>
    <form @submit.prevent="onSubmit" class="flex flex-column">
        <div>
            <h2>Nazwa kategori</h2>
            <input v-model="categoryForm.category_name" type="text" placeholder="Nazwa" class="m-1 input" required />
        </div>
        <Button type="submit" label="Save" class="m-3" />
    </form>
</template> 
 
<script setup lang="ts">
import { defineEmits } from "vue";
import { useSaveCategory } from "@/../utils/useSaveCategory";

const props = defineProps({
    id: {
        type: Number,
        default: 0,
    },
});
const { saveCategory, categoryForm } = useSaveCategory();
const emit = defineEmits(['refresh']);

const onSubmit = async () => {
    await saveCategory(categoryForm, props.id).then(() => {
        emit('refresh');
    });
};
</script>
<style scoped></style>
  