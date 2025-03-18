<template>
    <AppLayout title="Dashboard" class="dashboard-main">
        <Container>
            <div class="text-white py-20">
                <!-- Global Language Selector -->
                <div class="flex flex-row items-end justify-center mb-6">
                    <div v-for="table in table" :key="table.id">
                        <h1 class="text-6xl">Current table: <span>{{ table.name }}</span></h1>
                    </div>
                    <div class="language-selector flex justify-end items-end ml-auto">
                        <select v-model="selectedLanguage" class="d-main-input alt !min-w-28">
                            <option value="en">English</option>
                            <option value="nl">Dutch</option>
                            <option value="fr">French</option>
                        </select>
                    </div>
                </div>

                <form @submit.prevent="submitrecordform">
                    <button class="d-main-btn mb-4" type="submit">Create Record</button>
                </form>

                <form @submit.prevent="submit">
                    <div class="flex flex-row gap-2 mb-4">
                        <input v-model="form.name" type="text" class="d-main-input" placeholder="Label.."/>
                        <div v-if="form.errors.name" class="text-red-500 text-sm mt-1">{{ form.errors.name }}</div>
                        <select v-model="form.category" class="d-main-input alt">
                            <option v-for="field in fields" :key="field.id" :value="field.slug">
                                {{ field.name }}
                            </option>
                        </select>
                        <button class="d-main-btn" type="submit">Create</button>
                    </div>
                </form>

                <div v-for="record in records" class="mb-4">
                    <div class="d-main-parentblock">
                        <span>{{ record.id }}</span>
                        <!--<div v-for="combine in combiner" :key="combine.id">-->
                            <!-- Pass selectedLanguage to ExtraDetail -->
                            <!--<ExtraDetail v-if="combine.record_id === record.id" :combiner="combine" :selectedLanguage="selectedLanguage"/>-->
                        <!--</div>-->
                        <ExtraDetail :combiner="combiner" :selectedLanguage="selectedLanguage" :recordId="record.id" />
                    </div>
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
import { ref } from 'vue';

export default {
    props: {
        table: Array,
        fields: Array,
        combiner: Array,
        records: Array,
    },
    components: {
        Container,
        AppLayout,
        ExtraDetail,
    },
    setup(props) {
        // Global language state (shared with all fields)
        const selectedLanguage = ref(window.appLanguage || 'en');

        const form = useForm({
            name: "",
            category: "title",
            errors: {},
        });

        const recordform = useForm({
            name: "",
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

        const submitrecordform = () => {
            recordform.post(route('builder.createrecord', { id: props.table[0].id }), {
                onError: (errors) => {
                    recordform.errors = errors;
                },
                forceFormData: true,
            });
        };

        return { form, submit, recordform, submitrecordform, selectedLanguage };
    },
}
</script>