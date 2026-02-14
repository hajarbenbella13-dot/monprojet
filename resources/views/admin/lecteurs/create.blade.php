<!-- resources/views/lecteurs/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter un Lecteur
        </h2>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto">
        <form action="{{ route('lecteurs.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Nom:</label>
                <input type="text" name="nom" required
                       class="w-full border-gray-300 rounded-md shadow-sm p-2">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Age:</label>
                <input type="number" name="age" required min="1"
                       class="w-full border-gray-300 rounded-md shadow-sm p-2">
            </div>

            <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Créer Lecteur
            </button>
        </form>
    </div>
</x-app-layout>
