@if (session()->has('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 10000)" x-show="show"
        class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50">
        {{ session('success') }}
    </div>
@endif

@if (session()->has('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 10000)" x-show="show"
        class="fixed bottom-5 right-5 bg-red-500 text-white px-4 py-2 rounded shadow-lg z-50">
        {{ session('error') }}
    </div>
@endif

@if (session()->has('warning'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 10000)" x-show="show"
        class="fixed bottom-5 right-5 bg-yellow-500 text-white px-4 py-2 rounded shadow-lg z-50">
        {{ session('warning') }}
    </div>
@endif

@if (session()->has('message'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 10000)" x-show="show"
        class="fixed bottom-5 right-5 bg-blue-500 text-white px-4 py-2 rounded shadow-lg z-50">
        {{ session('message') }}
    </div>
@endif
