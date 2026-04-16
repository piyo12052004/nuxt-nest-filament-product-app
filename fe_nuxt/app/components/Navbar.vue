<template>
  <nav
    class="w-full bg-white border-b border-gray-300 px-6 py-3 flex items-center justify-between"
  >
    <!-- LEFT: Logo + Brand -->
    <div class="flex items-center gap-3">
      <!-- Logo -->
      <div
        class="w-10 h-10 bg-green-700 rounded-lg flex items-center justify-center"
      >
        <span class="text-white font-bold">🌲</span>
      </div>

      <!-- Brand -->
      <div>
        <h1 class="font-bold text-gray-800 leading-4">CLT Layup</h1>
        <p class="text-xs text-gray-500">MANAGER</p>
      </div>
    </div>

    <!-- CENTER: Menu -->
    <div class="hidden md:flex items-center gap-8 text-sm font-medium">
      <!-- <NuxtLink to="/" class="text-gray-500 hover:text-green-700">
        Dashboard
      </NuxtLink> -->

      <NuxtLink
        to="/"
        :class="
          route.path === '/'
            ? 'text-green-700 border-b-2 border-green-700 pb-1'
            : 'text-gray-500 hover:text-green-700'
        "
      >
        Dashboard
      </NuxtLink>

      <NuxtLink
        to="/product"
        :class="
          route.path.startsWith('/product')
            ? 'text-green-700 border-b-2 border-green-700 pb-1'
            : 'text-gray-500 hover:text-green-700'
        "
      >
        Produk
      </NuxtLink>
    </div>

    <!-- RIGHT: Notification + User -->
    <div class="flex items-center gap-4">
      <!-- Notification -->
      <button class="relative p-2 rounded-full hover:bg-gray-100">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="size-6"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0M3.124 7.5A8.969 8.969 0 0 1 5.292 3m13.416 0a8.969 8.969 0 0 1 2.168 4.5"
          />
        </svg>

        <span
          class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"
        ></span>
      </button>

      <!-- Divider -->
      <div class="h-6 w-px bg-gray-300"></div>

      <!-- User -->
      <div class="relative flex items-center gap-3">
        <!-- USER BUTTON -->
        <div
          class="cursor-pointer flex items-center gap-3"
          @click="togglePopup"
        >
          <div
            class="w-9 h-9 bg-gray-200 rounded-full flex items-center justify-center"
          >
            👤
          </div>

          <div class="text-sm leading-4">
            <p class="font-semibold text-gray-800">
              {{ session?.name ? session?.name : "-" }}
            </p>
            <p class="text-xs text-gray-500">
              {{ session?.email ? session?.email : "-" }}
            </p>
          </div>
        </div>

        <!-- POPUP -->
        <div
          v-if="isOpen"
          class="absolute right-0 top-15 w-48 bg-white border border-gray-300 shadow-lg rounded-lg p-2 z-50"
        >
          <button
            class="w-full text-left px-3 py-2 hover:bg-gray-100 rounded"
            @click="handleLoginAction"
          >
            {{ session?.name ? "Logout" : "Login" }}
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
// import { checkAuth } from '../middleware/auth'
import * as H from "@tools/Helper";

const route = useRoute();

const { session } = H.useAuth();

const router = useRouter();

const isOpen = ref(false);

// simulasi login (nanti ganti auth real)
const isLoggedIn = ref(false);

const togglePopup = () => {
  isOpen.value = !isOpen.value;
};

const handleLoginAction = () => {
  H.logout();
};

const logout = () => {
  isLoggedIn.value = false;
  isOpen.value = false;
};

// checkAuth()
</script>