<template>
    <AppLayout title="Dashboard">
        <Container>
            <div class="text-white py-20">
                <div v-for="table in table" :key="table.id">
                    <h1 class="text-6xl">Current table: {{ table.name }}</h1>
                </div>
                <form @submit.prevent="submit">
                    <input v-model="form.name" type="text" class="placeholder:text-black text-black"/>
                    <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                    <select v-model="form.category" class="text-black placeholder:text-black">
                        <option v-for="field in fields" :key="field.id" :value="field.slug">
                            {{ field.name }}
                        </option>
                    </select>
                    <button type="submit">Create</button>
                </form>
                <div v-for="combine in combiner">
                    <ExtraDetail :combiner="combine"/>
                    <!--{{ combine.content }}
                    {{ combine.field.name }}
                    {{ combine.field.category }}-->
                </div>
            </div>
        </Container>
    </AppLayout>
</template>

<script>
import Container from '@/Components/Container.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import ExtraDetail from '@/Pages/Tables/ExtraDetail.vue';
import { useForm } from '@inertiajs/vue3';

export default {
    props: {
        table: Array,
        fields: Array,
        combiner: Array,
    },
    components: {
        Container,
        AppLayout,
        ExtraDetail,
    },
    setup(props) {
        const form = useForm({
            name: "",
            category: "title",
            errors: {},
        });

        const submit = () => {
            form.post(route('builder.duplicate', { id: props.table[0].id }), {
                onError: (errors) => {
                    form.errors = errors;
                },
                forceFormData: true,
            });
        };

        return { form, submit };
    },
}
</script>