<div class="fixed top-5 right-5 z-50 space-y-3 w-80">
    @foreach (['success' => 'green', 'error' => 'red', 'info' => 'blue', 'status' => 'yellow'] as $type => $color)
        @if (session($type))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="p-4 rounded-lg shadow-lg text-white bg-{{ $color }}-500">
                <span>{{ session($type) }}</span>
                <button @click="show = false" class="ml-4 text-white">&times;</button>
            </div>
        @endif
    @endforeach
</div>
