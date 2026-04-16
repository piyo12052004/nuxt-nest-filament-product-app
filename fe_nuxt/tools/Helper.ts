import { navigateTo, useState } from 'nuxt/app'
import { onMounted, reactive, ref } from 'vue'
import { useApi } from "@services/useApi";

const state = reactive({
  toasts: [] as any[],
})

let toastInstance: any = null

export const useToast = () => {
  if (toastInstance) return toastInstance

  const show = (type: string, message: string, title = '') => {
    state.toasts.push({
      id: Date.now(),
      type,
      message,
      title,
    })

    setTimeout(() => {
      state.toasts.shift()
    }, 3000)
  }

  toastInstance = {
    toasts: state.toasts,
    success: (msg: string, title = 'Success') => show('success', msg, title),
    error: (msg: string, title = 'Error') => show('error', msg, title),
    warning: (msg: string, title = 'Warning') => show('warning', msg, title),
    info: (msg: string, title = 'Info') => show('info', msg, title),
  }

  return toastInstance
}

export async function saveStorege(row: any) {
  localStorage.setItem("token", row);
}

export async function fecthSession(row: any) {
  localStorage.setItem("user", JSON.stringify(row));
}


export const useAuth = () => {
  const session = useState<any>("session", () => null);
  const loadSession = () => {
    if (import.meta.client) {
      session.value = JSON.parse(localStorage.getItem("user") || "null");
    }
  };
  loadSession();
  return { session };
};

export const logout = async () => {
  try {
    const res: any = await useApi().post('/auth/logout')

    if (res.message === 'Logout berhasil') {
      localStorage.clear()
      navigateTo('/')
    }
  } catch (error) {
    localStorage.clear()
    navigateTo('/')
  }
}

