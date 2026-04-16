<template>
  <transition
    enter-active-class="transition duration-200 ease-out"
    enter-from-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="transition duration-150 ease-in"
    leave-from-class="opacity-100"
    leave-to-class="opacity-0"
  >
    <div
      v-if="modelValue"
      class="fixed inset-0 z-50 flex items-center justify-center"
    >
      <!-- BACKDROP -->
      <div
        class="absolute inset-0 bg-black/50"
        @click="close"
      ></div>

      <!-- MODAL -->
      <transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="scale-95 opacity-0"
        enter-to-class="scale-100 opacity-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="scale-100 opacity-100"
        leave-to-class="scale-95 opacity-0"
      >
        <div
          class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 z-10"
        >
          <!-- HEADER -->
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">
              <slot name="title" />
            </h2>

            <button @click="close" class="text-gray-400 hover:text-black">
              ✕
            </button>
          </div>

          <!-- BODY -->
          <div class="mb-4">
            <slot />
          </div>

          <!-- FOOTER -->
          <div class="flex justify-end gap-2">
            <slot name="footer" />
          </div>
        </div>
      </transition>
    </div>
  </transition>
</template>

<script setup>
const props = defineProps({
  modelValue: Boolean,
});

const emit = defineEmits(["update:modelValue"]);

const close = () => {
  emit("update:modelValue", false);
};
</script>