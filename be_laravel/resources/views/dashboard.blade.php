<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">

            <!-- TOP BAR -->
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-4">

                <!-- LEFT: SEARCH -->
                <form method="GET" class="w-full max-w-sm relative flex items-center">

                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <!-- icon -->
                    </span>

                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Produk... | klik enter"
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg
                               bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200
                               focus:outline-none focus:ring-2 focus:ring-green-600">

                </form>

                <!-- RIGHT: FILTER + BUTTON -->
                <div x-data class="flex items-center gap-3">

                    <!-- STATUS FILTER -->
                    <form method="GET" class="flex items-center gap-2">

                        <!-- keep search value -->
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <label class="text-sm text-gray-600 dark:text-gray-300">
                            Filter:
                        </label>

                        <select name="status" onchange="this.form.submit()"
                            class="border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2
                                   bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                   focus:ring-2 focus:ring-green-600">

                            <option value="">All</option>
                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Produk Aktive
                            </option>
                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Produk yang di hapus
                            </option>

                        </select>

                    </form>

                    <!-- ADD BUTTON -->
                    <button {{-- @click="$store.modal.open('add_produk')" --}} @click="$store.modal.open('add_produk')"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        + Produk
                    </button>

                </div>

            </div>

            <!-- CONTENT -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                            <!-- TABLE -->
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">

                                    <!-- HEADER -->
                                    <thead class="text-gray-500 uppercase text-xs border-b dark:border-gray-700">
                                        <tr>
                                            <th class="py-3">Name</th>
                                            <th>Price</th>
                                            <th>Created At</th>
                                            <th>Status</th>
                                            <th class="text-right">Actions</th>
                                        </tr>
                                    </thead>

                                    <!-- BODY -->
                                    <tbody class="divide-y dark:divide-gray-700">

                                        @forelse ($products as $produk)
                                            <tr class="border-b dark:border-gray-700">

                                                <!-- NAME -->
                                                <td class="py-4 flex items-center gap-3">
                                                    <div
                                                        class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-semibold">
                                                        {{ strtoupper(substr($produk->name, 0, 2)) }}
                                                    </div>

                                                    <div class="font-semibold">
                                                        {{ $produk->name }}
                                                    </div>
                                                </td>

                                                <!-- DATE -->
                                                <td>
                                                    Rp {{ number_format($produk->price, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    {{ $produk->created_at->format('d M Y') }}
                                                </td>
                                                <td>
                                                    @if ($produk->status)
                                                        <span
                                                            class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-700">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span
                                                            class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-700">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- ACTION -->
                                                <td class="text-right" x-data="{
                                                    open: false,
                                                    top: 0,
                                                    left: 0,

                                                    toggle(event) {
                                                        this.open = !this.open

                                                        const rect = event.target.getBoundingClientRect()

                                                        this.top = rect.bottom + window.scrollY
                                                        this.left = rect.right - 176
                                                    }
                                                }">
                                                    <button @click="toggle($event)"
                                                        class="px-3 py-1 text-sm border rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                                                        Action
                                                    </button>
                                                    <template x-teleport="body">
                                                        <div x-show="open" @click.outside="open = false" x-transition
                                                            class="fixed z-50 w-44 bg-white dark:bg-gray-800
                       border dark:border-gray-700 rounded-xl shadow-lg"
                                                            :style="`top: ${top}px; left: ${left}px;`">

                                                            <!-- Show -->
                                                            <button
                                                                @click="$store.modal.open('show_produk', {{ Js::from($produk) }})"
                                                                class="w-full text-yellow-100 text-left flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                Show
                                                            </button>
                                                            <!-- EDIT -->
                                                            <button
                                                                @click="$store.modal.open('edit_produk', {{ Js::from($produk) }})"
                                                                class="w-full text-blue-100 text-left flex items-center gap-2 px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                                                Edit
                                                            </button>

                                                            <!-- DELETE -->
                                                            <button
                                                                @click="$store.modal.open('delete_produk', {{ Js::from($produk) }})"
                                                                class="w-full text-left flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </template>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center py-6">
                                                    No Data Found
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>
                                <div
                                    class="mt-4 flex justify-between items-center text-sm text-gray-600 dark:text-gray-300">

                                    <div>
                                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }}
                                        of {{ $products->total() }} results
                                    </div>

                                    <div>
                                        {{ $products->links() }}
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <x-popup.modal name="delete_produk" title="Delete Product">

        <div class="text-gray-900 dark:text-gray-100 space-y-3">

            <p class="text-red-600 dark:text-red-400">
                Are you sure you want to delete:
            </p>

            <div class="p-3 rounded-lg bg-gray-100 dark:bg-gray-700">
                <b x-text="$store.modal.data?.name"></b>
            </div>

        </div>

        <form x-bind:action="`/product/${$store.modal.data?.id}`" method="POST" class="mt-4">
            @csrf
            @method('DELETE')

            <div class="flex gap-2">

                <!-- CANCEL -->
                <button type="button" @click="$store.modal.close()"
                    class="w-1/2 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white">
                    Cancel
                </button>

                <!-- DELETE -->
                <button type="submit"
                    class="w-1/2 py-2 rounded-lg text-white font-medium bg-red-600 hover:bg-red-700 transition">
                    Delete
                </button>

            </div>

        </form>

    </x-popup.modal>


    <x-popup.modal name="show_produk" title="Edit Product">
        <div class="space-y-3 text-gray-900 dark:text-gray-100">

            <!-- NAME -->
            <div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Name</div>
                <div class="font-semibold" x-text="$store.modal.data?.name"></div>
            </div>

            <!-- STATUS -->
            <div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Status</div>
                <span class="px-2 py-1 text-xs rounded"
                    :class="$store.modal.data?.status ?
                        'bg-green-100 text-green-700' :
                        'bg-red-100 text-red-700'"
                    x-text="$store.modal.data?.status ? 'Active' : 'Inactive'"></span>
            </div>

            <!-- PRICE -->
            <div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Price</div>
                <div class="font-semibold">
                    Rp <span x-text="Number($store.modal.data?.price).toLocaleString('id-ID')"></span>
                </div>
            </div>

            <!-- DESCRIPTION -->
            <div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Description</div>
                <div x-text="$store.modal.data?.description"></div>
            </div>

            <!-- CREATED AT -->
            <div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Created At</div>
                <div x-text="$store.modal.data?.created_at"></div>
            </div>

        </div>

        <!-- BUTTON CLOSE -->
        <div class="mt-5">
            <button @click="$store.modal.close()"
                class="w-full py-2 rounded-lg bg-gray-700 hover:bg-gray-800 text-white">
                Close
            </button>
        </div>
    </x-popup.modal>

    <x-popup.modal name="edit_produk" title="Edit Product">

        <!-- DEBUG -->
        {{-- <button type="button" @click="console.log($store.modal.data)"
            class="px-3 py-2 bg-gray-800 text-white rounded mb-3">
            Debug Data
        </button> --}}

        <form x-bind:action="`/product/${$store.modal.data?.id}`" method="POST"
            class="space-y-4 text-gray-900 dark:text-gray-100">
            @csrf
            @method('PUT')

            <!-- NAME -->
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">
                    Name
                </label>
                <input type="text" name="name" x-model="$store.modal.data.name"
                    class="w-full px-4 py-2 rounded-lg border
                       border-gray-300 dark:border-gray-600
                       bg-white dark:bg-gray-700
                       text-gray-900 dark:text-gray-100
                       focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <!-- PRICE -->
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">
                    Price
                </label>
                <input type="number" name="price" x-model="$store.modal.data.price"
                    class="w-full px-4 py-2 rounded-lg border
                       border-gray-300 dark:border-gray-600
                       bg-white dark:bg-gray-700
                       text-gray-900 dark:text-gray-100
                       focus:ring-2 focus:ring-green-500 focus:outline-none">
            </div>

            <!-- STATUS -->
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">
                    Status
                </label>
                <select name="status" x-model="$store.modal.data.status"
                    class="w-full px-4 py-2 rounded-lg border
                       border-gray-300 dark:border-gray-600
                       bg-white dark:bg-gray-700
                       text-gray-900 dark:text-gray-100
                       focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <option value="1">True</option>
                    <option value="0">False</option>
                </select>
            </div>

            <!-- DESCRIPTION -->
            <div>
                <label class="block text-sm mb-1 text-gray-700 dark:text-gray-300">
                    Description
                </label>
                <textarea name="description" x-model="$store.modal.data.description"
                    class="w-full px-4 py-2 rounded-lg border
                       border-gray-300 dark:border-gray-600
                       bg-white dark:bg-gray-700
                       text-gray-900 dark:text-gray-100
                       focus:ring-2 focus:ring-green-500 focus:outline-none"></textarea>
            </div>

            <!-- BUTTON -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full py-2 rounded-lg text-white font-medium
                       bg-green-600 hover:bg-green-700
                       transition">
                    Update Product
                </button>
            </div>

        </form>

    </x-popup.modal>
    <x-popup.modal name="add_produk" title="Tambah Product">
        <form action="/product" method="POST" class="space-y-4 text-gray-900 dark:text-gray-100">
            @csrf

            <div>
                <label class="block text-sm mb-1 font-medium text-gray-700 dark:text-gray-300">Name</label>
                <input type="text" name="name"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                           focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
            </div>

            <div>
                <label class="block text-sm mb-1 font-medium text-gray-700 dark:text-gray-300">Price</label>
                <input type="number" name="price"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                           focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
            </div>

            {{-- <div>
                <label class="block text-sm mb-1 font-medium text-gray-700 dark:text-gray-300">Status</label>
                <select name="status"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                           focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition">
                    <option value="1">True</option>
                    <option value="0">False</option>
                </select>
            </div> --}}

            <div>
                <label class="block text-sm mb-1 font-medium text-gray-700 dark:text-gray-300">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100
                           focus:ring-2 focus:ring-green-500 focus:border-transparent outline-none transition"></textarea>
            </div>

            <div class="pt-2">
                <button type="submit"
                    class="w-full py-2.5 rounded-lg bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600
                           text-white font-semibold shadow-md transition-all active:scale-[0.98]">
                    Save Product
                </button>
            </div>
        </form>
    </x-popup.modal>

</x-app-layout>
