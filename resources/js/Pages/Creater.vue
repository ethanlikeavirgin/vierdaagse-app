<script setup>
    import { useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
</script>
<template>
    <AppLayout title="Dashboard">
        <div class="relative z-50 pb-20">
            <h1 class="text-white text-sm pb-4">Create a New Table</h1>
            <div class="flex flex-row gap-2 mb-6">
                <input class="main_input" type="text" placeholder="Table Name" />
                <span class="error">Error message here</span>
                <button class="main_btn">Create Table</button>
            </div>
            
            <div class="bg-gray-200/25 rounded-45px p-6 mt-4 items-center justify-center duration-500">
                <div class="flex flex-row space-x-2 relative">
                    <a><x-map-table></x-map-table></a>
                    <span class="text-white text-sm">Example Table</span>
                    <a class="cursor-pointer bg-yellow-500/65 rounded-full h-10 w-10 flex items-center justify-center absolute right-0 -top-8 m-auto rotate-90">
                        <x-map-arrowwatcher></x-map-arrowwatcher>
                    </a>
                </div>
                
                <div>
                    <div class="bg-black p-6 rounded-45px flex flex-row items-center space-x-6 mb-2 relative">
                        <a class="cursor-pointer h-10 w-10 bg-black rounded-full flex items-center justify-center absolute -top-4 right-0">
                            <x-map-arrow></x-map-arrow>
                        </a>
                        <x-sidenav></x-sidenav>
                        <a class="text-white text-sm">1</a>
                        <div class="flex flex-row space-x-2">
                            <div class="flex flex-col relative">
                                <span class="text-white text-12px absolute -top-5">Name - String</span>
                                <input class="main_input" type="text" value="John Doe"/>
                            </div>
                            <div class="flex flex-col relative">
                                <span class="text-white text-12px absolute -top-5">Age - Integer</span>
                                <input class="main_input" type="text" value="30"/>
                            </div>
                        </div>
                        <button class="main_btn flex !items-end !justify-center !ml-auto">Save</button>
                    </div>
                </div>
                
                <div class="space-x-2">
                    <div class="mb-2">
                        <input class="!w-32 main_input" type="text" placeholder="Field name"/>
                        <input class="!w-32 main_input" type="text" placeholder="Field type"/>
                        <button class="main_btn">New Field</button>
                    </div>
                </div>
                <button class="main_btn flex w-fit">New entry</button>
            </div>
        </div>
    </AppLayout>
</template>