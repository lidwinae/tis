<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';

defineOptions({
    layout: AppLayout,
});
</script>

<template>
    <section class="bg-white py-20">
        <div class="container mx-auto px-4">
            
            <!-- Div dengan gambar di kiri dan teks di kanan -->
            <div class="flex flex-col md:flex-row items-center gap-8 text-center">
                <!-- Bagian gambar (kiri) -->
                <div class="w-full md:w-1/2">
                    <img 
                        src="/book.svg" 
                        alt="Gambar Mahasiswa" 
                        class="w-full h-auto rounded-lg"
                    >
                </div>
                
                <!-- Bagian teks (kanan) -->
                <div class="w-full md:w-1/2 text-center">
                    <h2 class="text-4xl font-bold mb-4 text-gray-800">Mahastudent</h2>
                    <p class="text-lg text-gray-600">
                        Aplikasi untuk mahasiswa
                    </p>
                    <!-- Anda bisa menambahkan lebih banyak konten teks di sini -->
                </div>
            </div>
        </div>
    </section>
</template>
