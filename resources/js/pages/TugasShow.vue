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

interface Jawaban {
    id: number;
    jawaban_text: string;
    nilai: number | null;
    created_at: string;
    updated_at: string;
}

const props = defineProps<{
    id: string;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Detail Tugas',
        href: `/tugas/${props.id}`,
    },
];

const tugas = ref<Tugas | null>(null);
const jawaban = ref<Jawaban | null>(null);
const jawabanForm = ref({
    jawaban_text: ''
});
const isLoading = ref(true);
const error = ref<string | null>(null);
const isSubmitting = ref(false);
const submitError = ref<string | null>(null);
const submitSuccess = ref<string | null>(null);

const deadlineStatus = (deadline: string) => {
    const now = new Date();
    const deadlineDate = new Date(deadline);
    return deadlineDate < now ? 'text-red-500' : 'text-green-500';
};

// Fetch data tugas dan jawaban
const fetchData = async () => {
    try {
        const [tugasResponse, jawabanResponse] = await Promise.all([
            axios.get(`/api/tugas/${props.id}`),
            axios.get(`/api/tugas/${props.id}/jawabans`)
        ]);
        
        tugas.value = tugasResponse.data;
        jawaban.value = jawabanResponse.data;
    } catch (err) {
        error.value = 'Gagal memuat data';
        console.error(err);
    } finally {
        isLoading.value = false;
    }
};

onMounted(fetchData);

const submitJawaban = async () => {
    if (!jawabanForm.value.jawaban_text.trim()) {
        submitError.value = 'Jawaban tidak boleh kosong';
        return;
    }

    isSubmitting.value = true;
    submitError.value = null;
    submitSuccess.value = null;

    try {
        await axios.post(`/api/tugas/${props.id}/jawaban`, {
            jawaban_text: jawabanForm.value.jawaban_text
        });
        
        submitSuccess.value = 'Jawaban berhasil dikirim!';
        await fetchData(); // Refresh data setelah submit
        jawabanForm.value.jawaban_text = '';
    } catch (err: any) {
        submitError.value = err.response?.data?.message || 'Gagal mengirim jawaban';
        console.error(err);
    } finally {
        isSubmitting.value = false;
    }
};
</script>

<template>
    <Head :title="tugas?.judul || 'Detail Tugas'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
            <!-- Loading State -->
            <div v-if="isLoading" class="text-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto"></div>
                <p class="mt-4 text-gray-600">Memuat detail tugas...</p>
            </div>

            <!-- Error State -->
            <div v-else-if="error" class="text-center py-12 bg-red-50 rounded-lg">
                <div class="mx-auto h-12 w-12 text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-red-800">{{ error }}</h3>
                <button 
                    @click="fetchData"
                    class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                >
                    Coba Lagi
                </button>
            </div>

            <!-- Success State -->
            <div v-else-if="tugas" class="space-y-6">
                <!-- Detail Tugas -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                {{ tugas.judul }}
                            </h3>
                            <span 
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                                :class="deadlineStatus(tugas.deadline)"
                            >
                                Deadline: {{ new Date(tugas.deadline).toLocaleDateString() }}
                            </span>
                        </div>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Deskripsi Tugas</h4>
                            <p class="text-gray-800 whitespace-pre-line">{{ tugas.deskripsi }}</p>
                        </div>

                        <div v-if="tugas.dosen" class="mb-6">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Dosen Pengampu</h4>
                            <p class="text-gray-800">{{ tugas.dosen.name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Jawaban Section -->
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Jawaban Anda
                        </h3>
                    </div>
                    
                    <!-- Jika sudah ada jawaban -->
                    <div v-if="jawaban" class="px-4 py-5 sm:p-6">
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Jawaban</h4>
                            <p class="text-gray-800 whitespace-pre-line">{{ jawaban.jawaban_text }}</p>
                        </div>
                        
                        <div v-if="jawaban.nilai" class="mb-4">
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Nilai</h4>
                            <p class="text-gray-800">{{ jawaban.nilai }}</p>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Dikirim pada</h4>
                            <p class="text-gray-800">{{ new Date(jawaban.created_at).toLocaleString() }}</p>
                        </div>
                    </div>
                    
                    <!-- Form Jawaban -->
                    <div v-else class="px-4 py-5 sm:p-6">
                        <form @submit.prevent="submitJawaban">
                            <!-- Success Message -->
                            <div v-if="submitSuccess" class="mb-4 p-4 bg-green-50 text-green-800 rounded-md">
                                {{ submitSuccess }}
                            </div>

                            <!-- Error Message -->
                            <div v-if="submitError" class="mb-4 p-4 bg-red-50 text-red-800 rounded-md">
                                {{ submitError }}
                            </div>

                            <div class="mb-4">
                                <textarea
                                    id="jawaban"
                                    v-model="jawabanForm.jawaban_text"
                                    rows="6"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Tulis jawaban Anda disini..."
                                    :disabled="isSubmitting"
                                ></textarea>
                            </div>
                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    :disabled="isSubmitting"
                                >
                                    <span v-if="isSubmitting">Mengirim...</span>
                                    <span v-else>Kirim Jawaban</span>
                                </button>
                            </div>
                        </form>
                    </div>
                
                </div>

                <!-- Tombol Kembali -->
                <div class="flex justify-start">
                    <Link 
                        href="/tugas" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Kembali ke Daftar Tugas
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>