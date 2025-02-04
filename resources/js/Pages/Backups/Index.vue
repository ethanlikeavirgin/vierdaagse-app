<script setup>
import { usePage } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';

const { props } = usePage();

const createBackup = () => {
    router.post(route('backups.create'), {}, {
        onSuccess: () => alert('Backup created successfully!')
    });
};

const restoreBackup = (fileName) => {
    router.post(route('backups.restore'), { file: fileName }, {
        onSuccess: () => alert('Backup restored successfully!')
    });
};
</script>

<template>
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Backup Management</h1>

        <button
            @click="createBackup"
            class="bg-blue-500 text-white px-4 py-2 rounded mb-6"
        >
            Create Backup
        </button>

        <h2 class="text-xl font-semibold mb-2">Available Backups</h2>
        <ul>
            <li v-for="file in props.files" :key="file.name" class="flex justify-between items-center mb-4">
                <span>{{ file.name }}</span>
                <button
                    @click="restoreBackup(file.name)"
                    class="bg-green-500 text-white px-3 py-1 rounded"
                >
                    Restore
                </button>
            </li>
        </ul>
    </div>
</template>