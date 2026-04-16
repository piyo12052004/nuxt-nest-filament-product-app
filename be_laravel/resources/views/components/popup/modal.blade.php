@props([
    'name',
    'title' => 'Modal',
    'width' => 'max-w-md',
])

<div
    x-data
    x-show="$store.modal.active === '{{ $name }}'"
    x-cloak
    x-transition.opacity
    class="fixed inset-0 flex items-center justify-center bg-black/50 z-50"
>

    <div
        @click.outside="$store.modal.close()"
        class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full p-6 {{ $width }}"
    >

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                {{ $title }}
            </h2>

            <button
                @click="$store.modal.close()"
                class="text-gray-500 hover:text-red-500"
            >
                ✕
            </button>
        </div>

        <!-- BODY -->
        <div>
            {{ $slot }}
        </div>

    </div>
</div>
