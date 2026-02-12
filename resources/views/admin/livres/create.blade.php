<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un nouveau Livre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                
                <form action="{{ route('livres.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf 

                    <div class="space-y-4">
                        {{-- Titre --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Titre</label>
                            <input type="text" name="titre" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea name="description" class="w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
                        </div>

                        {{-- Age Min & Age Max --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Âge Minimum</label>
                                <input type="number" name="age_min" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Ex: 3">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Âge Maximum</label>
                                <input type="number" name="age_max" class="w-full border-gray-300 rounded-md shadow-sm" placeholder="Ex: 6">
                            </div>
                        </div>

                        {{-- Photo & Audio --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Photo (Couverture)</label>
                                <input type="file" name="photo" class="w-full mt-1">
                            </div>
                            <div>
                                <label class="block font-medium text-sm text-gray-700">Fichier Audio</label>
                                <input type="file" name="audio" class="w-full mt-1">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" style="background-color: #2563eb; color: white; padding: 10px 25px; border-radius: 6px; font-weight: bold;">
                                Enregistrer le livre
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>