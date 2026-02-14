<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Livres card -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-gray-500 font-bold">Livres</div>
                    <div class="text-3xl font-extrabold text-gray-800 mt-2">{{ \App\Models\Livre::count() }}</div>
                    <a href="{{ route('livres.index') }}" 
                       class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 font-semibold transition">
                       Voir Livres
                    </a>
                </div>

                <!-- Pages card -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-gray-500 font-bold">Pages</div>
                    <div class="text-3xl font-extrabold text-gray-800 mt-2">{{ \App\Models\Page::count() }}</div>
                    <a href="{{ route('livres.index') }}" 
                       class="mt-4 inline-block px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 font-semibold transition">
                       Voir Pages
                    </a>
                </div>

                <!-- Ajouter Livre -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition text-center">
                    <div class="text-gray-500 font-bold mb-2">Ajouter un Livre</div>
                    <a href="{{ route('livres.create') }}" 
                       class="px-4 py-2 bg-purple-500 text-white rounded hover:bg-purple-600 font-semibold transition">
                       ➕ Ajouter Livre
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
