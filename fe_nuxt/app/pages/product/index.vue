<template>
  <div class="p-6 bg-gray-50 min-h-screen">
    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
      <div>
        <h1 class="text-2xl font-bold text-gray-800">Produk</h1>
        <p class="text-gray-500 text-sm">Manage Produk.</p>
      </div>

      <button
        @click="handleInstert"
        class="flex items-center gap-2 bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg shadow"
      >
        + Add Product
      </button>
    </div>

    <!-- FILTER -->
    <div class="mb-4">
      <input
        v-model="search"
        type="text"
        placeholder="Search product..."
        class="w-full md:w-96 px-4 py-2 border rounded-lg"
      />
    </div>

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-visible">
      <table class="w-full text-left">
        <thead class="bg-gray-50 border-b">
          <tr class="text-sm text-gray-600">
            <th class="p-4">NAME</th>
            <th class="p-4">PRICE</th>
            <th class="p-4">CREATED AT</th>
            <th class="p-4 text-right">ACTIONS</th>
          </tr>
        </thead>

        <tbody>
          <tr v-if="loading">
            <td colspan="4" class="text-center p-4">Loading...</td>
          </tr>

          <tr
            v-for="item in suppliers"
            :key="item.id"
            class="border-b hover:bg-gray-50"
          >
            <!-- NAME -->
            <td class="p-4 flex items-center gap-3">
              <div
                class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold"
              >
                {{ getInitials(item.name) }}
              </div>

              <div>
                <p class="font-semibold text-gray-800">{{ item.name }}</p>
                <p class="text-xs text-gray-500">ID: {{ item.id }}</p>
              </div>
            </td>

            <!-- PRICE -->
            <td class="p-4 text-gray-700">
              Rp {{ item.price.toLocaleString() }}
            </td>

            <!-- DATE -->
            <td class="p-4 text-gray-500">
              {{ formatDate(item.created_at) }}
            </td>

            <!-- ACTION -->
            <td class="p-4 text-right">
              <div class="relative inline-block text-left">
                <!-- BUTTON -->
                <button
                  @click.stop="toggleDropdown(item.id)"
                  class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 transition"
                >
                  <span class="text-lg text-gray-600">⋮</span>
                </button>

                <!-- DROPDOWN -->
                <transition
                  enter-active-class="transition duration-100 ease-out"
                  enter-from-class="transform scale-95 opacity-0"
                  enter-to-class="transform scale-100 opacity-100"
                  leave-active-class="transition duration-75 ease-in"
                  leave-from-class="transform scale-100 opacity-100"
                  leave-to-class="transform scale-95 opacity-0"
                >
                  <div
                    v-if="activeDropdown === item.id"
                    class="absolute right-0 mt-2 w-44 bg-white rounded-xl shadow-lg border border-gray-300 z-50 py-1"
                  >
                    <!-- SHOW -->
                    <button
                      @click="handleShow(item)"
                      class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition"
                    >
                      <span class="text-blue-500"
                        ><svg
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
                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"
                          />
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                          />
                        </svg>
                      </span>
                      Show
                    </button>

                    <!-- EDIT -->
                    <button
                      @click="handleEdit(item)"
                      class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-700 hover:bg-yellow-50 hover:text-yellow-600 transition"
                    >
                      <span class="text-yellow-500"
                        ><svg
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
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                          />
                        </svg>
                      </span>
                      Edit
                    </button>

                    <!-- DIVIDER -->
                    <!-- <div class="my-1 border-t border-gray-300"></div> -->

                    <!-- DELETE -->
                    <!-- <button
                      @click="handleDelete(item)"
                      class="flex items-center gap-3 w-full px-4 py-2 text-sm text-red-500 hover:bg-red-50 transition"
                    >
                      <span
                        ><svg
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
                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                          />
                        </svg>
                      </span>
                      Delete
                    </button> -->
                  </div>
                </transition>
              </div>
            </td>
          </tr>
        </tbody>
      </table>

      <!-- FOOTER -->
      <div class="flex items-center justify-between p-4 text-sm text-gray-500">
        <span>
          Showing {{ (page - 1) * limit + 1 }} to
          {{ (page - 1) * limit + suppliers.length }} of
          {{ meta.total || 0 }} results
        </span>

        <div class="flex gap-2 items-center">
          <!-- Prev -->
          <button
            @click="prevPage"
            :disabled="page === 1"
            class="px-3 py-1 border rounded disabled:opacity-50"
          >
            ←
          </button>

          <!-- Page Numbers -->
          <button
            v-for="n in meta.lastPage"
            :key="n"
            @click="goPage(n)"
            :class="[
              'px-3 py-1 border rounded',
              page === n ? 'bg-black text-white' : '',
            ]"
          >
            {{ n }}
          </button>

          <!-- Next -->
          <button
            @click="nextPage"
            :disabled="page === meta.lastPage"
            class="px-3 py-1 border rounded disabled:opacity-50"
          >
            →
          </button>
        </div>
      </div>
    </div>
  </div>

  <BaseModal v-model="deleteModal">
    <!-- TITLE -->
    <template #title>
      <div class="flex items-center gap-2 text-red-600">
        <!-- ICON -->
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="w-5 h-5"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 9v2m0 4h.01M5.455 19h13.09c1.054 0 1.71-1.14 1.184-2.028L13.184 4.972c-.527-.889-1.84-.889-2.368 0L4.27 16.972C3.744 17.86 4.401 19 5.455 19z"
          />
        </svg>

        <span class="font-semibold">Delete Produk</span>
      </div>
    </template>

    <!-- CONTENT -->
    <div class="text-center py-4">
      <p class="text-gray-700">Yakin ingin menghapus produk ini?</p>
      <p class="text-sm text-gray-400 mt-1">
        Data yang sudah dihapus tidak bisa dikembalikan.
      </p>
    </div>

    <!-- FOOTER -->
    <template #footer>
      <div class="flex justify-end gap-2">
        <!-- CANCEL -->
        <button
          @click="deleteModal = false"
          class="px-4 py-2 rounded-lg border text-gray-600 hover:bg-gray-100 transition"
        >
          Cancel
        </button>

        <!-- DELETE -->
        <button
          @click="confirmDelete"
          class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition"
        >
          Delete
        </button>
      </div>
    </template>
  </BaseModal>

  <BaseModal v-model="updateModal">
    <!-- TITLE -->
    <template #title>
      <div class="flex items-center gap-2">
        <span class="font-semibold">Edit Produk</span>
      </div>
    </template>

    <!-- CONTENT -->
    <div class="space-y-4 text-sm">
      <!-- NAME -->
      <div>
        <label class="block text-gray-600 mb-1">Nama Produk</label>
        <input
          v-model="data_update.name"
          type="text"
          placeholder="Masukkan nama produk"
          class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 px-3 py-2 rounded-lg outline-none transition"
        />
      </div>

      <!-- PRICE -->
      <div>
        <label class="block text-gray-600 mb-1">Harga</label>
        <input
          v-model="data_update.price"
          type="number"
          placeholder="Masukkan harga"
          class="w-full border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 px-3 py-2 rounded-lg outline-none transition"
        />
      </div>

      <!-- DESCRIPTION -->
      <div>
        <label class="block text-gray-600 mb-1">Deskripsi</label>
        <textarea
          v-model="data_update.description"
          placeholder="Masukkan deskripsi produk"
          rows="3"
          class="w-full border border-gray-300 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 px-3 py-2 rounded-lg outline-none transition"
        ></textarea>
      </div>
    </div>

    <!-- FOOTER -->
    <template #footer>
      <div class="flex justify-end gap-2">
        <button
          @click="updateModal = false"
          class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition"
        >
          Batal
        </button>

        <button
          @click="submitUpdate"
          class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow transition"
        >
          Simpan
        </button>
      </div>
    </template>
  </BaseModal>

  <BaseModal v-model="inserteModal">
    <!-- TITLE -->
    <template #title>
      <div class="flex items-center gap-2">
        <span class="font-semibold">Edit Produk</span>
      </div>
    </template>

    <!-- CONTENT -->
    <div class="space-y-4 text-sm">
      <!-- NAME -->
      <div>
        <label class="block text-gray-600 mb-1">Nama Produk</label>
        <input
          v-model="data_insert.name"
          type="text"
          placeholder="Masukkan nama produk"
          class="w-full border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 px-3 py-2 rounded-lg outline-none transition"
        />
      </div>

      <!-- PRICE -->
      <div>
        <label class="block text-gray-600 mb-1">Harga</label>
        <input
          v-model="data_insert.price"
          type="number"
          placeholder="Masukkan harga"
          class="w-full border border-gray-300 focus:border-green-500 focus:ring-1 focus:ring-green-500 px-3 py-2 rounded-lg outline-none transition"
        />
      </div>

      <!-- DESCRIPTION -->
      <div>
        <label class="block text-gray-600 mb-1">Deskripsi</label>
        <textarea
          v-model="data_insert.description"
          placeholder="Masukkan deskripsi produk"
          rows="3"
          class="w-full border border-gray-300 focus:border-purple-500 focus:ring-1 focus:ring-purple-500 px-3 py-2 rounded-lg outline-none transition"
        ></textarea>
      </div>
    </div>

    <!-- FOOTER -->
    <template #footer>
      <div class="flex justify-end gap-2">
        <button
          @click="inserteModal = false"
          class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition"
        >
          Batal
        </button>

        <button
          @click="submitInsert"
          class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow transition"
        >
          Simpan
        </button>
      </div>
    </template>
  </BaseModal>

  <BaseModal v-model="showModal">
    <template #title> Detail produk </template>

    <div class="space-y-4">
      <!-- NAME -->
      <div>
        <p class="text-xs text-gray-500">Nama Produk</p>
        <p class="font-semibold text-gray-800">
          {{ data_show_produk?.name || "-" }}
        </p>
      </div>

      <!-- DESCRIPTION -->
      <div>
        <p class="text-xs text-gray-500">Deskripsi</p>
        <p class="text-gray-700">
          {{ data_show_produk?.description || "-" }}
        </p>
      </div>

      <!-- PRICE -->
      <div>
        <p class="text-xs text-gray-500">Harga</p>
        <p class="font-semibold text-green-600">
          Rp {{ data_show_produk?.price.toLocaleString() }}
        </p>
      </div>

      <!-- CREATED AT -->
      <div>
        <p class="text-xs text-gray-500">Tanggal Dibuat</p>
        <p class="text-gray-700">
          {{ formatDate(data_show_produk?.created_at) }}
        </p>
      </div>
    </div>

    <template #footer>
      <button @click="showModal = false" class="px-4 py-2 border rounded-lg">
        Close
      </button>
    </template>
  </BaseModal>
</template>

<script setup>
import { ref, onMounted, watch, onBeforeUnmount } from "vue";
import { useApi } from "@services/useApi";
import BaseModal from "@components/ui/BaseModal";
import * as H from "@tools/Helper";

var data_show_produk = ref({});
var data_update = ref({});
var data_delete = ref({});
var data_insert = ref({});
var showModal = ref(false);
var updateModal = ref(false);
var deleteModal = ref(false);
var inserteModal = ref(false);

const toast = H.useToast();
const suppliers = ref([]);
const meta = ref({});
const loading = ref(false);

const page = ref(1);
const limit = ref(5);
const search = ref("");

const activeDropdown = ref(null);

// FETCH DATA
const fetchData = async () => {
  try {
    loading.value = true;

    const res = await useApi().get("/products", {
      page: page.value,
      limit: limit.value,
      name: search.value,
    });

    suppliers.value = res.data;
    meta.value = res.meta;
  } catch (error) {
    console.error(error);
  } finally {
    loading.value = false;
  }
};

// INIT
onMounted(fetchData);

// SEARCH
watch(search, () => {
  page.value = 1;
  fetchData();
});

// PAGINATION
const nextPage = () => {
  if (page.value < (meta.value.lastPage || 1)) {
    page.value++;
    fetchData();
  }
};

const prevPage = () => {
  if (page.value > 1) {
    page.value--;
    fetchData();
  }
};

const goPage = (n) => {
  page.value = n;
  fetchData();
};

// DROPDOWN
const toggleDropdown = (id) => {
  activeDropdown.value = activeDropdown.value === id ? null : id;
};

// CLICK OUTSIDE
const closeDropdown = () => {
  activeDropdown.value = null;
};

onMounted(() => {
  window.addEventListener("click", closeDropdown);
});

onBeforeUnmount(() => {
  window.removeEventListener("click", closeDropdown);
});

// ACTIONS
const handleShow = (item) => {
  showModal.value = true;
  data_show_produk.value = item;
};

const handleEdit = (item) => {
  updateModal.value = true;
  data_update.value = item;
};

const handleDelete = (item) => {
  deleteModal.value = true;
  data_delete.value = item;
};
const handleInstert = () => {
  inserteModal.value = true;
};

// HELPERS
const getInitials = (name) => {
  return name
    ?.split(" ")
    .map((n) => n[0])
    .join("")
    .slice(0, 2)
    .toUpperCase();
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString("id-ID");
};

const submitUpdate = async () => {
  try {
    loading.value = true;
    var payload = data_update.value;
    const res = await useApi().put(
      `/products/${data_update.value.id}`,
      payload
    );

    toast.success(res.message);
  } catch (error) {
    toast.error(error?.response?.data?.message || "Update Gagal");
  } finally {
    data_update.value = {};
    updateModal.value = false;
    fetchData();
    loading.value = false;
  }
};
const confirmDelete = async () => {
  try {
    loading.value = true;
    const res = await useApi().delete(`/products/${data_delete.value.id}`);

    toast.success(res.message);
  } catch (error) {
    toast.error(error?.response?.data?.message || "Delete Gagal");
  } finally {
    deleteModal.value = false;
    data_delete.value = {};
    fetchData();
    loading.value = false;
  }
};

const submitInsert = async () => {
  try {
    loading.value = true;

    var data = data_insert.value;
    if(!data.description || !data.name || !data.price){
        toast.warning('Input tidak boleh kosong');
        return
    }
    var varb = {
      description: data.description,
      name: data.name,
      price: data.price,
    };
    const res = await useApi().post(`/products`, varb);

    toast.success(res.message);
  } catch (error) {
    toast.error(error?.response?.data?.message || "Insert Gagal");
  } finally {
    inserteModal.value = false;
    data_insert.value = {}
    fetchData();
    loading.value = false;
  }
};

definePageMeta({
  middleware: ["auth"],
});
</script>