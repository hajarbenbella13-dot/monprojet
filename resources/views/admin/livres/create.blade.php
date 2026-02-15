<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un nouveau livre') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-emerald-500">
                
                <form action="{{ route('livres.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-6">
                        {{-- Titre --}}
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Titre du livre</label>
                            <input type="text" name="titre" value="{{ old('titre') }}" placeholder="Ex: Le Petit Prince"
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition">
                            @error('titre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block font-bold text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3" placeholder="Résumé du livre..."
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 transition">{{ old('description') }}</textarea>
                        </div>

                        {{-- Sélection de l'âge (C'est ici que ça change !) --}}
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                            <label class="block font-bold text-gray-700 mb-2">Tranche d'âge cible</label>
                            <select name="age_range" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="" disabled selected>-- Choisissez une tranche d'âge --</option>
                                <option value="2-5" {{ old('age_range') == '2-5' ? 'selected' : '' }}>👶 De 2 à 5 ans</option>
                                <option value="6-10" {{ old('age_range') == '6-10' ? 'selected' : '' }}>👦 De 6 à 10 ans</option>
                            </select>
                            @error('age_range') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Photo --}}
                        <div class="bg-emerald-50/30 p-4 rounded-lg border border-emerald-100">
                            <label class="block font-bold text-gray-700 mb-2">Photo de couverture</label>
                            <input type="file" name="photo" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-600 file:text-white hover:file:bg-emerald-700 cursor-pointer">
                            @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Audio --}}
                        <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                            <label class="block font-bold text-gray-700 mb-2">Fichier Audio (MP3/WAV)</label>
                            <input type="file" name="audio" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-slate-600 file:text-white hover:file:bg-slate-700 cursor-pointer">
                            @error('audio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Actions --}}
                        <div class="pt-6 flex items-center justify-between border-t border-gray-100">
                            <a href="{{ route('livres.index') }}" class="text-gray-500 hover:text-gray-700 font-medium">
                                Annuler
                            </a>
                            
                            <button type="submit" class="flex items-center bg-white border-2 border-gray-300 hover:border-gray-500 text-gray-600 hover:text-gray-800 px-6 py-2 rounded-lg font-bold transition duration-200 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                CRÉER LE LIVRE
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>