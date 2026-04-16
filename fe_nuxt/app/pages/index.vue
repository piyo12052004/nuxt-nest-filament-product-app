<template>
  <div class="flex items-center justify-center h-screen bg-gray-50">
    <h1
      class="text-4xl font-bold text-gray-800 dark:text-gray-100 uppercase tracking-widest"
    >
      <NuxtLink to="/product" class="text-gray-500 hover:text-green-700">
        Go Produk
      </NuxtLink>
    </h1>
  </div>
</template>

<script setup>
definePageMeta({
  middleware: ["auth"],
});
</script>