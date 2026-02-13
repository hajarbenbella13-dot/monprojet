<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le livre :') }} <span class="text-amber-600">{{ $livre->titre }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-amber-500">
                
                <form action="{{ route('livres.update', $livre->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        {{-- Titre --}}
                        <div>
                            <label class="block font-bold text-gray-700">Titre</label>
                            <input type="text" name="titre" value="{{ old('titre', $livre->titre) }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block font-bold text-gray-700">Description</label>
                            <textarea name="description" rows="3" 
                                      class="w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">{{ old('description', $livre->description) }}</textarea>
                        </div>

                        {{-- Tranche d'âge --}}
                        <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                            <label class="block font-bold text-gray-700 mb-2">Tranche d'âge cible</label>
                            <select name="age_range" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">
                                <option value="2-5" {{ (old('age_range', $livre->age_min.'-'.$livre->age_max) == '2-5') ? 'selected' : '' }}>
                                    👶 De 2 à 5 ans
                                </option>
                                <option value="5-10" {{ (old('age_range', $livre->age_min.'-'.$livre->age_max) == '5-10') ? 'selected' : '' }}>
                                    👦 De 5 à 10 ans
                                </option>
                            </select>
                        </div>

                        {{-- Photo (Tswira sghira w-16) --}}
                        <div class="bg-amber-50/50 p-4 rounded-md border border-amber-100">
                            <label class="block font-bold text-gray-700 mb-2">Photo de couverture</label>
                            @if($livre->photo)
                                <div class="flex items-center gap-4 mb-3">
                                    {{-- Tsghira hna --}}
                                    <img src="{{ asset('storage/' . $livre->photo) }}" class="w-16 h-16 object-cover rounded shadow-sm border-2 border-white">
                                    <span class="text-xs text-amber-700 italic font-medium">Image actuelle</span>
                                </div>
                            @endif
                            <input type="file" name="photo" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-amber-100 file:text-amber-700 hover:file:bg-amber-200">
                        </div>

                        {{-- Actions --}}
                        <div class="pt-6 flex items-center justify-between border-t border-gray-100">
                            <a href="{{ route('livres.index') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">
                                ← Annuler les changements
                            </a>
                            
                            {{-- Bouton "Mettre à jour" b l-gris (outline style) --}}
                            <button type="submit" class="flex items-center bg-white border-2 border-gray-300 hover:border-gray-500 text-gray-600 hover:text-gray-800 px-6 py-2 rounded-lg font-bold transition duration-200 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Mettre à jour le livre
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>