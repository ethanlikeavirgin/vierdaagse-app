<template>
    <Container>
        <section class="text-white py-20">
            <div>
                <form @submit.prevent="submit">
                    <input v-model="form.name" type="text" class="placeholder:text-black text-black"/>
                    <select v-model="form.category" type="text" class="placeholder:text-black text-black">
                        <option default>Page</option>
                        <option>Reusable Content</option>
                    </select>
                    <button type="submit" :disabled="form.processing" class="">Create</button>
                </form>
            </div>
        </section>
    </Container>
</template>
<script>
import { useForm } from '@inertiajs/vue3';
import Container from '@/Components/Container.vue';
export default {
    setup() {
        const form = useForm({
            name: '',
            slug: '',
            category: '',
        });

        const submit = () => {
            form.post(route('tables.store'), {
                forceFormData: true,
            });
        };

        return { form, submit };
    },
    components: {
        Container,
    }
};
</script>