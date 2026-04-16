<script setup >
import { useApi } from "@services/useApi";
import * as H from "@tools/Helper";

const data = ref({});
const toast = H.useToast();

const login = async () => {
  const varb = {
    email: data.value.email,
    password: data.value.password,
  };
  if(!varb.email){
    toast.warning('Email masih kosong');
    return
  }
  if(!varb.password){
    toast.warning('Password masih kosong');
    return
  }

  try {
    const res = await useApi().post("/auth/login", varb);
    if(res.message == "Berhasil login"){
      H.saveStorege(res.access_token)
      const users = await useApi().get("/auth/get-users")
      if(users.message == 'success'){
        H.fecthSession(users.data);
      }
      toast.success(res.message);
    }
    await navigateTo("/product")
  } catch (error) {
    toast.error(error?.response?.data?.message || "Login gagal");
  }
};

definePageMeta({
  layout: "auth",
});
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Welcome Back 👋</h1>
        <p class="text-sm text-gray-500">Login to your account</p>
      </div>

      <form class="space-y-4" @submit.prevent="login">
        <!-- EMAIL -->
        <div>
          <label class="text-sm text-gray-600">Email</label>
          <input
            v-model="data.email"
            type="email"
            placeholder="you@example.com"
            class="w-full mt-1 px-4 py-2 border rounded-lg"
          />
        </div>

        <!-- PASSWORD -->
        <div>
          <label class="text-sm text-gray-600">Password</label>
          <input
            v-model="data.password"
            type="password"
            placeholder="••••••••"
            class="w-full mt-1 px-4 py-2 border rounded-lg"
          />
        </div>

        <button
          type="submit"
          class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-semibold"
        >
          Login
        </button>
      </form>
      <div class="text-center mt-4">
  <p class="text-sm text-gray-600">
    Belum punya akun? 
    <NuxtLink
      to="/auth/registrasi"
      class="text-green-600 font-bold hover:text-green-700 hover:underline"
    >
      Daftar sekarang
    </NuxtLink>
  </p>
</div>
    </div>
  </div>
</template>