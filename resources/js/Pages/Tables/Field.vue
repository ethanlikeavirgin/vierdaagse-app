<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Welcome from '@/Components/Welcome.vue';
    import { ref } from 'vue';
    import Container from '@/Components/Container.vue';
    import { useForm, router } from '@inertiajs/vue3';

    export default {
        props: {
            fields: Array,
        },
        components: {
            Container,
            AppLayout,
        },
        setup(){
            const form = useForm({
                name: '',
                category: 'title',
                errors: {},
            });
            const submit = () => {
                form.post(route('fields.store'), {
                    onError: (errors) => {
                        form.errors = errors;
                    },
                    forceFormData: true,
                });
            };
            return { form, submit};
        }
    }
</script>
<template>
    <AppLayout title="Field">
        <Container>
            <section class="text-white py-20">
                <div class="pb-10">
                    <h2>Basic Fields</h2>
                </div>
                <form @submit.prevent="submit">
                    <input v-model="form.name" type="text" class="placeholder:text-black text-black"/>
                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                    <select v-model="form.category" class="placeholder:text-black text-black">
                        <option value="title">title</option>
                        <option value="text">text</option>
                        <option value="image">image</option>
                        <option value="multi">multi</option>
                        <option value="form">form</option>
                        <option value="link">link</option>
                    </select>
                    <button type="submit">Create</button>
                </form>
                <div v-for="field in fields">
                    {{ field.id }} - {{ field.name }} - {{ field.slug }} - {{ field.category }}
                </div>
            </section>
        </Container>
    </AppLayout>
</template>