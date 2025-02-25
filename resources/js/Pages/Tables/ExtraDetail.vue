<template>
    <section>
        <div v-if="combiner.field.category === 'text'" class="editor-parent">
            <a class="text-black">{{ combiner.field.category }}</a>
            <!-- Toolbar -->
            <div v-if="editor" class="toolbar">
                <button class="toolbar-button" @click="editor.chain().focus().toggleBold().run()" :class="{ 'active': editor.isActive('bold') }">Bold</button>
                <button class="toolbar-button" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'active': editor.isActive('italic') }">Italic</button>
                <button class="toolbar-button" @click="editor.chain().focus().toggleUnderline().run()" :class="{ 'active': editor.isActive('underline') }">Underline</button>
                <button class="toolbar-button" @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :class="{ 'active': editor.isActive('heading', { level: 1 }) }">H1</button>
                <button class="toolbar-button" @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :class="{ 'active': editor.isActive('heading', { level: 2 }) }">H2</button>
                <button class="toolbar-button" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'active': editor.isActive('bulletList') }">Bullet List</button>
                <button class="toolbar-button" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'active': editor.isActive('orderedList') }">Numbered List</button>
                <button class="toolbar-button" @click="editor.chain().focus().toggleBlockquote().run()" :class="{ 'active': editor.isActive('blockquote') }">Blockquote</button>
                <button class="toolbar-button" @click="editor.chain().focus().undo().run()">Undo</button>
                <button class="toolbar-button" @click="editor.chain().focus().redo().run()">Redo</button>
            </div>
            <!-- TipTap Editor -->
            <editor-content v-if="editor" :editor="editor" class="tiptap-editor" v-model="form.content"/>
            <!-- Form Submission -->
            <form @submit.prevent="submit">
                <button class="btn btn--primary mt-4" type="submit">Submit</button>
            </form>
        </div>
        <div v-else-if="combiner.field.category === 'title'" class="editor-parent">
            <a class="text-black">{{ combiner.field.category }}</a>
            <form @submit.prevent="submit">
                <input v-model="form.content" type="text"/>
                <button class="btn btn--primary mt-4" type="submit">Submit</button>
            </form>
        </div>
        <div v-else-if="combiner.field.category === 'image'" class="editor-parent">
            <a class="text-black">{{ combiner.field.category }}</a>
            <form @submit.prevent="submit">
                <input @change="handleFileUpload" type="file"/>
                <button class="btn btn--primary mt-4" type="submit">Submit</button>
            </form>
            <img :src="`/storage/${combiner.content}`" class="w-12 h-12 rounded-md">
        </div>
        <div v-else-if="combiner.field.category === 'link'" class="editor-parent">
            <a class="text-black">{{ combiner.field.category }}</a>
            <form @submit.prevent="submit">
                <input v-model="form.content" type="url" name="url" id="url" placeholder="https://example.com" pattern="https://.*" size="30"/>
                <button class="btn btn--primary mt-4" type="submit">Submit</button>
            </form>
        </div>
    </section>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount, defineProps } from 'vue';
import { Editor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';

const props = defineProps({
    combiner: Object,
    table: Array,
});

// Reactive state for the editor
const editor = ref(null);
const form = useForm({
    name: "",
    category: "title",
    content: props.combiner?.content || "<p>Default content if combiner.content is empty.</p>",
    file: null,
    errors: {},
});

const handleFileUpload = (event) => {
    form.file = event.target.files[0];
    console.log(form.file);
};

const submit = () => {
    form.post(route('builder.savecontent', { id: props.combiner.id }), {
        onError: (errors) => {
            form.errors = errors;
        },
        forceFormData: true,
        preserveScroll: true,
    });
};

onMounted(() => {
    editor.value = new Editor({
        extensions: [
            StarterKit, 
            Underline, // Adds underline feature
        ],
        content: props.combiner?.content || "<p>Default content if combiner.content is empty.</p>", // Use combiner.content dynamically
        onUpdate: ({ editor }) => {
            form.content = editor.getHTML();
        }
    });
});

// Destroy editor on component unmount to avoid memory leaks
onBeforeUnmount(() => {
    if (editor.value) {
        editor.value.destroy();
    }
});
</script>