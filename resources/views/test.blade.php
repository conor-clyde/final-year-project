<x-app-layout>
    <x-slot name="header">
        <h2>Test Page</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>Test Page Working!</h3>
                    <p>If you can see this, the basic layout and authentication are working.</p>
                    <p>Current user: {{ auth()->user()->name }}</p>
                    <p>User role: {{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 