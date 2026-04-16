import { fileURLToPath } from 'url'
import { dirname, resolve } from 'path'
import tailwindcss from "@tailwindcss/vite"

const __dirname = dirname(fileURLToPath(import.meta.url))

export default defineNuxtConfig({
  compatibilityDate: '2025-07-15',

  devtools: { enabled: true },

  css: ['./app/assets/css/main.css'],

  vite: {
    plugins: [
      tailwindcss(),
    ],
  },

  // ✅ ALIAS SETTING
  alias: {
    '@': resolve(__dirname, './app'),
    '~': resolve(__dirname, './app'),
    '@plugins': resolve(__dirname, './plugins'),
    '@services': resolve(__dirname, './services'),
    '@utils': resolve(__dirname, './app/utils'),
    '@tools': resolve(__dirname, './tools'),
    '@components': resolve(__dirname, './app/components'),
  },
  devServer: {
    port: 3001
  }
})