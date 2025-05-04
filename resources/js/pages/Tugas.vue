<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

interface Tugas {
    id: number;
    judul: string;
    deskripsi: string;
    deadline: string;
    dosen?: {
        name: string;
    };
    created_at: string;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Tugas',
        href: '/tugas',
    },
];

const tugasList = ref<Tugas[]>([]);
const isLoading = ref(true);
const error = ref<string | null>(null);

const deadlineStatus = (deadline: string) => {
    const now = new Date();
    const deadlineDate = new Date(deadline);
    return deadlineDate < now ? 'text-red-500' : 'text-green-500';
};

// Fetch data saat komponen dimount
onMounted(async () => {
    try {
        const response = await axios.get('/api/tugas');
        tugasList.value = response.data;
    } catch (err) {
        error.value = 'Gagal memuat data tugas';
        console.error(err);
    } finally {
        isLoading.value = false;
    }
});
</script>

<template>
    <Head title="Tugas" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-900">Daftar Tugas</h1>
            </div>

            <!-- Loading State -->
            <div v-if="isLoading" class="text-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
                <p class="mt-4 text-gray-600">Memuat data tugas...</p>
            </div>

            <!-- Success State -->
            <div v-else>
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div 
                        v-for="tugas in tugasList" 
                        :key="tugas.id"
                        class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow"
                    >
                        <div class="p-6">
                            <div class="flex justify-between items-start">
                                <h2 class="text-xl font-semibold text-gray-800 mb-2">
                                    <Link :href="`/tugas/${tugas.id}`" class="hover:text-indigo-600">
                                        {{ tugas.judul }}
                                    </Link>
                                </h2>
                                <span 
                                    class="text-xs px-2 py-1 rounded-full"
                                    :class="deadlineStatus(tugas.deadline)"
                                >
                                    {{ new Date(tugas.deadline).toLocaleDateString() }}
                                </span>
                            </div>
                            
                            <p class="text-gray-600 mb-4 line-clamp-3">
                                {{ tugas.deskripsi }}
                            </p>
                            
                            <div class="flex justify-between items-center text-sm text-gray-500">
                                <span v-if="tugas.dosen">
                                    Dosen: {{ tugas.dosen.name }}
                                </span>
                                <Link 
                                    :href="`/tugas/${tugas.id}`"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium"
                                >
                                    Lihat Detail →
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="tugasList.length === 0" class="text-center py-12">
                    <PlaceholderPattern class="mx-auto h-24 w-24 text-gray-400" />
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Belum ada tugas</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Tunggu tugas baru dari dosen.
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>