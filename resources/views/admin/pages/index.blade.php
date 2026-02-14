<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pages du Livre : <span class="text-blue-600">{{ $livre->titre }}</span>
            </h2>
        
            <div class="flex gap-2">
                <a href="{{ route('pages.create', $livre->id) }}" 
                   class="bg-blue-500 text-gray px-4 py-2 rounded-lg font-semibold hover:bg-blue-600 transition shadow-sm">
                    ➕ Ajouter Pages
                </a>

                <a href="{{ route('livres.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 font-medium transition">
                   ← Retour aux Livres
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @forelse($pages as $page)
                <a href="{{ route('pages.show', $page->id) }}" 
                   class="flex items-center gap-4 bg-white p-4 border border-gray-200 rounded-xl shadow-sm hover:shadow-md hover:border-blue-400 transition">

                    <!-- Image sghira -->
                    <img src="{{ asset('storage/' . $page->image) }}" 
                    class="w-16 h-16 min-w-[64px] object-cover rounded-lg border border-gray-200 shadow-sm hover:scale-105 transition">

                    <!-- Contenu -->
                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-1">
                            <h3 class="font-bold text-gray-700 text-lg">
                                Page {{ $page->num_page }}
                            </h3>

                            @if($page->audio)
                                <span class="text-green-600 text-sm font-medium">
                                    🎵 Audio disponible
                                </span>
                            @endif
                        </div>

                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ Str::limit($page->contenu, 150) }}
                        </p>
                    </div>

                </a>
            @empty
                <p class="text-gray-400 text-center py-10">
                    Aucune page ajoutée pour ce livre.
                </p>
            @endforelse

        </div>
    </div>
</x-app-layout>
