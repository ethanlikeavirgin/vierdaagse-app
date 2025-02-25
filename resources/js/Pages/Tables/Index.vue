<template>
    <AppLayout title="Dashboard">
        <Container>
            <section class="text-white py-20">
                <div>
                    <div class="pb-10">
                        <h2>Maak een tabel aan</h2>
                    </div>

                    <form @submit.prevent="submit">
                        <input v-model="form.name" type="text" class="placeholder:text-black text-black"/>
                        <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                        <select v-model="form.category" class="placeholder:text-black text-black">
                            <option value="page">Page</option>
                            <option value="reusable-content">Reusable Content</option>
                        </select>
                        <button type="submit" class="">Create</button>
                    </form>

                    <label v-if="tables.length">Pages</label>
                    <div v-for="item in tables" :key="item.id">
                        <span v-if="editingId !== item.id">
                            {{ item.name }} - {{ item.category }} - {{ item.slug }}
                            <a @click="edit(item)">Edit</a>
                            <a @click="remove(item.id)">Remove</a>
                            <Link :href="route('builder.show', { id: item.id })" class="text-blue-500 hover:underline">goto</Link>
                        </span>
                        <span v-else>
                            <input v-model="editForm.name" type="text" class="text-black"/>
                            <select v-model="editForm.category" class="text-black">
                                <option value="page">Page</option>
                                <option value="reusable-content">Reusable Content</option>
                            </select>
                            <button @click="update(item.id)">Save</button>
                            <button @click="cancelEdit">Cancel</button>
                        </span>
                    </div>
                </div>
            </section>
        </Container>
    </AppLayout>
</template>

<script>
import { ref } from 'vue';
import Container from '@/Components/Container.vue';
import { useForm, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

export default {
    props: {
        tables: Array,
    },
    setup() {
        const isOpen = ref(false);
        const form = useForm({
            name: '',
            category: 'page',
            errors: {},
        });

        const editForm = useForm({
            name: '',
            category: '',
        });

        const editingId = ref(null);

        const submit = () => {
            form.post(route('builder.store'), {
                onError: (errors) => {
                    form.errors = errors;
                },
                forceFormData: true,
            });
        };

        const edit = (item) => {
            editingId.value = item.id;
            editForm.name = item.name;
            editForm.category = item.category;
        };

        const update = (id) => {
            router.put(route('builder.update', {builder: id}), editForm, {
                onSuccess: () => {
                    editingId.value = null;
                }
            });
        };

        const cancelEdit = () => {
            editingId.value = null;
        };

        const remove = (id) => {
            if (confirm('Are you sure you want to delete this?')) {
                router.delete(route('builder.destroy', { builder: id })); // 'builder' must match the resource route parameter
            }
        };


        return { form, submit, edit, update, remove, editForm, editingId, cancelEdit, isOpen };
    },
    components: {
        Container,
        AppLayout,
        Link,
    }
};
</script>