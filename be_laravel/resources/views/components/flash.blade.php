@php
    $types = ['success', 'error', 'warning', 'info'];

    $styles = [
        'success' => 'bg-green-500 text-white',
        'error'   => 'bg-red-500 text-white',
        'warning' => 'bg-yellow-500 text-white',
        'info'    => 'bg-blue-500 text-white',
    ];

    $titles = [
        'success' => 'SUCCESS',
        'error'   => 'ERROR',
        'warning' => 'WARNING',
        'info'    => 'INFO',
    ];
@endphp

<div class="fixed top-5 right-5 space-y-3 z-50">
    @foreach ($types as $type)
        @if (session($type))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 5000)"
                x-transition
                class="min-w-[260px] px-4 py-3 rounded shadow-lg {{ $styles[$type] }}"
            >
                <!-- TITLE -->
                <div class="font-bold text-sm uppercase mb-1">
                    {{ $titles[$type] }}
                </div>

                <!-- MESSAGE -->
                <div class="text-sm">
                    {{ session($type) }}
                </div>
            </div>
        @endif
    @endforeach
</div>
