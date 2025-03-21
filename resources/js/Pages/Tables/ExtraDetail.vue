<template>
    <section>
        <h2 class="text-lg font-bold mb-4">Record ID: {{ recordId }}</h2>

        <form @submit.prevent="submit" class="flex flex-col gap-4">
            <div v-for="combine in filteredCombiner" :key="combine.id">
                <div class="flex flex-col" v-if="combine.field.slug == 'title'">
                    <label class="font-bold">{{ combine.field.slug }}</label>
                    <input type="text" v-model="combine.content[selectedLanguage]" class="d-main-input"/>
                </div>
                <div class="flex flex-col" v-if="combine.field.slug == 'link'">
                    <label class="font-bold">{{ combine.field.slug }}</label>
                    <input type="link" v-model="combine.content[selectedLanguage]" class="d-main-input"/>
                </div>
                <div class="flex flex-col" v-if="combine.field.slug == 'text'">
                    <!-- Toolbar -->
                    <div v-if="editor" class="toolbar">
                        <button class="toolbar-button" @click="editor.chain().focus().toggleBold().run()" :class="{ 'active': editor.isActive('bold') }">Bold</button>
                        <button class="toolbar-button" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'active': editor.isActive('italic') }">Italic</button>
                        <button class="toolbar-button" @click="editor.chain().focus().toggleUnderline().run()" :class="{ 'active': editor.isActive('underline') }">Underline</button>
                        <button class="toolbar-button" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'active': editor.isActive('heading', { level: 1 }) }">H1</button>
                        <button class="toolbar-button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'active': editor.isActive('heading', { level: 2 }) }">H2</button>
                    </div>
                    <editor-content v-if="editor" :editor="editor" class="tiptap-editor"/>
                </div>
            </div>
            <button class="d-main-btn mt-4" type="submit">Save Fields</button>
        </form>
    </section>
</template>

<script setup>
import { ref, computed, defineProps, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Editor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';

const props = defineProps({
    combiner: Array, // All fields
    selectedLanguage: String, // Active language
    recordId: Number // The current record ID
});

// Reactive editor instance
const editor = ref(null);

// Computed property to get content dynamically
const currentContent = computed(() => props.form.content[props.combiner.id]?.[props.selectedLanguage] || "");

// Initialize TipTap Editor
onMounted(() => {
    editor.value = new Editor({
        extensions: [StarterKit, Underline],
        content: currentContent.value,
        onUpdate: ({ editor }) => {
            emit("updateContent", props.combiner.id, props.selectedLanguage, editor.getHTML());
        }
    });
});

// ✅ Form should track live updates
const form = useForm({
    id: props.recordId,
    content: computed(() => 
        props.combiner.map(combine => ({
            id: combine.id, // ✅ This is what you need for updates
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
    console.log(props.recordId);
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