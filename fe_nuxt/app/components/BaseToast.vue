<template>
  <div class="fixed top-4 right-4 space-y-2 z-50">
    <div
      v-for="t in safeToasts"
      :key="t.id"
      class="px-4 py-3 rounded-lg shadow text-white min-w-[250px]"
      :class="{
        'bg-green-500': t.type === 'success',
        'bg-red-500': t.type === 'error',
        'bg-yellow-500': t.type === 'warning',
        'bg-blue-500': t.type === 'info',
      }"
    >
      <div class="font-semibold">{{ t.title }}</div>
      <div class="text-sm">{{ t.message }}</div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { useToast } from "@tools/Helper";

const toast = useToast();

const safeToasts = computed(() => {
  return Array.isArray(toast.toasts) ? toast.toasts.filter(Boolean) : [];
});

</script>