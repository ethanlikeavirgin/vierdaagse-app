<template>
    <section>
        <h2 class="text-lg font-bold mb-4">Record ID: {{ recordId }}</h2>

        <form @submit.prevent="submit" class="flex flex-col gap-4">
            <!-- Language Selector -->
            <div class="flex gap-2">
                <label class="block font-semibold">Language:</label>
                <select :value="selectedLanguage" @change="updateLanguage($event.target.value)" class="d-main-input">
                    <option v-for="lang in availableLanguages" :key="lang" :value="lang">
                        {{ lang.toUpperCase() }}
                    </option>
                </select>
            </div>

            <div v-for="combine in filteredCombiner" :key="combine.field.slug">
                <!-- Title Field -->
                <div v-if="combine.field.slug === 'title'">
                    <label class="block font-semibold">{{ combine.field.slug }}</label>
                    <input class="d-main-input" type="text" :value="translations[combine.field.slug][selectedLanguage]" 
                        @input="updateTranslation(combine.field.slug, $event.target.value)" />
                </div>

                <!-- Text Field with TipTap Editor -->
                <div v-if="combine.field.slug === 'text'">
                    <label class="block font-semibold">{{ combine.field.slug }}</label>

                    <!-- Toolbar -->
                    <div v-if="editor" class="toolbar">
                        <button class="toolbar-button" @click="editor.chain().focus().toggleBold().run()" 
                            :class="{ 'active': editor.isActive('bold') }">Bold</button>
                        <button class="toolbar-button" @click="editor.chain().focus().toggleItalic().run()" 
                            :class="{ 'active': editor.isActive('italic') }">Italic</button>
                        <button class="toolbar-button" @click="editor.chain().focus().toggleUnderline().run()" 
                            :class="{ 'active': editor.isActive('underline') }">Underline</button>
                    </div>

                    <!-- TipTap Editor -->
                    <editor-content v-if="editor" :editor="editor" class="tiptap-editor" />
                </div>

                <!-- Link Field -->
                <div v-if="combine.field.slug === 'link'">
                    <label class="block font-semibold">{{ combine.field.slug }}</label>
                    <input class="d-main-input" type="text" :value="translations[combine.field.slug][selectedLanguage]" 
                        @input="updateTranslation(combine.field.slug, $event.target.value)" />
                </div>
                
                <!-- Image Upload -->
                <div v-if="combine.field.slug === 'image'">
                    <label class="block font-semibold">Image</label>
                    <input type="file" @change="handleImageUpload" accept="image/*" />
                    <img v-if="imagePreview" :src="imagePreview" class="w-32 h-32 mt-2 object-cover border" />
                </div>
            </div>

            <!-- Submit Button -->
            <button class="d-main-btn mt-4" type="submit">Save Fields</button>
        </form>
    </section>
</template>

<script setup>
import { ref, watch, onMounted, defineProps, defineEmits, onBeforeUnmount } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { Editor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';

const props = defineProps({
    combiner: Array, // All fields
    selectedLanguage: String, // Active language
    recordId: Number // The current record ID
});

const emit = defineEmits(["update:selectedLanguage"]); // Emits updates to parent
const availableLanguages = ref(["en", "nl", "fr"]);
const translations = ref({});
const imageFile = ref(null);
const imagePreview = ref(null);

// Initialize translations object
onMounted(() => {
    props.combiner.forEach(combine => {
        if (combine.field.slug !== "image") {
            translations.value[combine.field.slug] = JSON.parse(combine.builder.savecontent || "{}");
        }
    });
});

// Update language method (emit to parent)
const updateLanguage = (lang) => {
    emit("update:selectedLanguage", lang);
};

// Update translation fields
const updateTranslation = (field, value) => {
    translations.value[field][props.selectedLanguage] = value;
};

// Handle TipTap Editor
const editor = ref(null);
watch(
    () => translations.value["text"]?.[props.selectedLanguage],
    (newValue) => {
        if (editor.value) {
            editor.value.commands.setContent(newValue || "");
        }
    }
);

onMounted(() => {
    editor.value = new Editor({
        extensions: [StarterKit, Underline],
        content: translations.value["text"]?.[props.selectedLanguage] || "",
        onUpdate: ({ editor }) => {
            updateTranslation("text", editor.getHTML());
        },
    });
});

onBeforeUnmount(() => {
    if (editor.value) {
        editor.value.destroy();
    }
});

// Handle Image Upload
const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        imageFile.value = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

// Submit Form
const submit = () => {
    const form = useForm({
        recordId: props.recordId,
        content: JSON.stringify(translations.value),
        image: imageFile.value
    });

    form.post("/save-translation", {
        preserveScroll: true,
        onSuccess: () => {
            alert("Data saved successfully!");
        },
    });
};
</script>

<style>
.toolbar {
    display: flex;
    gap: 5px;
    margin-bottom: 10px;
}
.toolbar-button {
    padding: 5px 10px;
    border: 1px solid #ccc;
    cursor: pointer;
}
.toolbar-button.active {
    background-color: #ddd;
}
.tiptap-editor {
    border: 1px solid #ddd;
    min-height: 150px;
    padding: 10px;
}
</style>