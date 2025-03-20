<template>
    <section>
        <h2 class="text-lg font-bold mb-4">Record ID: {{ recordId }}</h2>

        <form @submit.prevent="submit" class="flex flex-col gap-4">
            <div v-for="combine in filteredCombiner" :key="combine.id">
                <div v-if="combine.field.slug == 'title'">
                    <label class="font-bold">{{ combine.field.slug }}</label>
                    <input type="text" v-model="combine.content[selectedLanguage]" class="d-main-input"/>
                </div>
                <div v-if="combine.field.slug == 'link'">
                    <label class="font-bold">{{ combine.field.slug }}</label>
                    <input type="link" v-model="combine.content[selectedLanguage]" class="d-main-input"/>
                </div>
            </div>

            <button class="d-main-btn mt-4" type="submit">Save Fields</button>
        </form>
    </section>
</template>

<script setup>
import { ref, computed, defineProps } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    combiner: Array, // All fields
    selectedLanguage: String, // Active language
    recordId: Number // The current record ID
});

// ✅ Form should track live updates
const form = useForm({
    id: props.recordId,
    content: computed(() => 
        props.combiner.map(combine => ({
            field_slug: combine.field.slug,
            translations: { ...combine.content } // ✅ Ensure reactive updates
        }))
    )
});

// Filter records for the selected record ID
const filteredCombiner = computed(() => 
    props.combiner.filter(c => c.record_id === props.recordId)
);

// ✅ Track field updates
const updateField = (combine) => {
    const fieldIndex = form.content.findIndex(item => item.field_slug === combine.field.slug);
    if (fieldIndex !== -1) {
        form.content[fieldIndex].translations = { ...combine.content };
    }
};

const submit = () => {
    console.log("Submitting Data:", form.content); // ✅ Debugging log

    form.post(route('builder.savecontent', { id: props.recordId }), {
        onError: (errors) => {
            console.error("Error saving content:", errors);
        },
        forceFormData: true,
        preserveScroll: true,
    });
};
</script>

<style scoped>
/* Styling */
.toolbar {
    display: flex;
    gap: 5px;
    margin-bottom: 8px;
}
.toolbar-button {
    padding: 5px 10px;
    border: 1px solid #ccc;
    cursor: pointer;
    background-color: white;
}
.toolbar-button.active {
    background-color: #007bff;
    color: white;
}
.tiptap-editor {
    border: 1px solid #ddd;
    padding: 10px;
    min-height: 100px;
}
</style>