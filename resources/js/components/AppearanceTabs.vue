<script setup lang="ts">
import { useAppearance } from '@/composables/useAppearance';
import { Sun } from 'lucide-vue-next';

const { updateAppearance } = useAppearance();
updateAppearance('light');
</script>

<template>
    <div class="inline-flex gap-1 rounded-lg bg-neutral-100 p-1">
        <button
            @click="updateAppearance('light')"
            class="flex items-center rounded-md bg-white px-3.5 py-1.5 shadow-xs"
        >
            <Sun class="-ml-1 h-4 w-4" />
            <span class="ml-1.5 text-sm">Light</span>
        </button>
    </div>
</template>