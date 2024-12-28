<template>
    <Head title="Products"/>
    <FrontendLayout>
        <div class="mt-4 mx-4">
            <div class="flex justify-between">
                <h5>Products Lists</h5>
                <Link :href="route('products.create')" class="bg-blue-500 text-white p-4 rounded mb-4">Add Product</Link>
            </div>
            <table class="w-full bg-white border border-gray-200 shadow">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-left border">Id</th>
                        <th class="py-2 px-4 text-left border">Name</th>
                        <th class="py-2 px-4 text-left border">Price</th>
                        <th class="py-2 px-4 text-left border">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in products" :key="index">
                        <td class="py-2 px-4 border">{{ item.id }}</td>
                        <td class="py-2 px-4 border">{{ item.name }}</td>
                        <td class="py-2 px-4 border">{{ item.price }}</td>
                        <td>
                            <!--<Link :href="route('products.show', 1)" class="px-2 oy-1 text-sm bg-blue-300 text-dark me-2 rounded inline-block">Show</Link>-->
                            <Link :href="route('products.create', 2)" class="bg-blue-500 text-white p-4 rounded mb-4">Edit</Link>
                            <button type="submit" class="">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </FrontendLayout>
</template>

<script setup>
import FrontendLayout from '@/Layouts/FrontendLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
defineProps({
    'products': Array,
});
</script>