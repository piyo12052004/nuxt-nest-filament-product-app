<script setup>
import { useApi } from "@services/useApi";
import * as H from "@tools/Helper";

// State data menggunakan ref
const data = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: ''
});

const toast = H.useToast();

const register = async () => {
  // Validasi Sederhana
  if(!data.value.name) return toast.warning('Nama wajib diisi');
  if(!data.value.email) return toast.warning('Email wajib diisi');
  if(!data.value.password) return toast.warning('Password wajib diisi');
  if(data.value.password !== data.value.password_confirmation) {
    return toast.warning('Konfirmasi password tidak cocok');
  }

  try {
    const res = await useApi().post("/auth/register", data.value);
    
    // Biasanya setelah register, kita bisa langsung login-kan user atau arahkan ke login
    toast.success("Registrasi berhasil! Silahkan login.");
    
    // Pindah ke halaman login
    await navigateTo("/auth/login");
  } catch (error) {
    toast.error(error?.response?.data?.message || "Registrasi gagal");
  }
};

definePageMeta({
  layout: "auth",
});
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-12">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Create Account ✨</h1>
        <p class="text-sm text-gray-500">Join us and start managing your products</p>
      </div>

      <form class="space-y-4" @submit.prevent="register">
        <div>
          <label class="text-sm font-medium text-gray-600">Full Name</label>
          <input
            v-model="data.name"
            type="text"
            placeholder="John Doe"
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
          />
        </div>

        <div>
          <label class="text-sm font-medium text-gray-600">Email Address</label>
          <input
            v-model="data.email"
            type="email"
            placeholder="you@example.com"
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
          />
        </div>

        <div>
          <label class="text-sm font-medium text-gray-600">Password</label>
          <input
            v-model="data.password"
            type="password"
            placeholder="••••••••"
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
          />
        </div>

        <div>
          <label class="text-sm font-medium text-gray-600">Confirm Password</label>
          <input
            v-model="data.password_confirmation"
            type="password"
            placeholder="••••••••"
            class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 outline-none"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-green-600 hover:bg-green-700 text-white py-2.5 rounded-lg font-semibold transition duration-200"
        >
          Sign Up
        </button>

        <div class="text-center mt-4">
          <p class="text-sm text-gray-600">
            Already have an account? 
            <NuxtLink to="/login" class="text-green-600 font-bold hover:underline">Login</NuxtLink>
          </p>
        </div>
      </form>
    </div>
  </div>
</template>