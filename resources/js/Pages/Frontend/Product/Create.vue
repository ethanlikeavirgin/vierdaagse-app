<template>
    <Head title="Products"/>
    <FrontendLayout>
        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h5>Products Lists</h5>
                <Link :href="route('products.index')" class="bg-danger-500 text-white p-4 rounded mb-4">Back</Link>
            </div>
            <form @submit.prevent="saveProduct()">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-6">
                        <div class="mb-3">
                            <label>Product name</label>
                            <input type="text" v-model="form.name" class="py-1 w-full"/>
                        </div>
                        <div class="mb-3">
                            <label>Product Price</label>
                            <input type="text" v-model="form.price" class="py-1 w-full"/>
                        </div>
                        <div class="mb-3">
                            <Link :href="route('products.index')" class="bg-danger-500 text-white p-4 rounded mb-4">Back</Link>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white py-2 px-5 rounded mb-4">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </FrontendLayout>
</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    price: '',
});

const saveProduct = () => {
    form.post(route('products.store'), {
        onSuccess: () => {
            form.reset();
            // Optionally, redirect or show success message
        },
        onError: (errors) => {
            console.log('Validation errors:', errors);
        }
    });
};

</script>