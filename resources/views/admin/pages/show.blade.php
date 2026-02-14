<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Page {{ $page->num_page }} du Livre : 
                <span class="text-blue-600">{{ $page->livre->titre }}</span>
            </h2>
            <a href="{{ route('pages.create', $page->livre->id) }}" class="text-gray-600 font-bold">← Retour</a>
        </div>
    </x-slot>

    <div class="py-12 max-w-3xl mx-auto space-y-8">

        <div class="bg-white p-6 shadow-sm sm:rounded-lg text-center">
            
            {{-- Image --}}
            @if($page->image)
                <img src="{{ asset('storage/' . $page->image) }}" 
                     class="mx-auto mb-6 w-80 h-80 object-cover rounded-lg border">
            @endif

            {{-- Audio --}}
            @if($page->audio)
                <audio controls class="w-full mb-6">
                    <source src="{{ asset('storage/' . $page->audio) }}" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
            @endif

            {{-- Contenu --}}
            <p class="text-gray-800 text-xl font-semibold leading-relaxed break-words">
                {{ $page->contenu }}
            </p>

            {{-- Buttons --}}
            <div class="mt-6 flex justify-center gap-3">
                <a href="{{ route('pages.create', ['livre' => $page->livre->id, 'edit' => $page->id]) }}" 
                   class="px-5 py-2 bg-amber-500 text-gray rounded hover:bg-amber-600 font-medium">✏️ Modifier</a>
                <form action="{{ route('pages.destroy', $page->id) }}" method="POST" 
                      onsubmit="return confirm('Supprimer cette page ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-5 py-2 bg-red-600 text-white rounded hover:bg-red-700 font-medium">🗑️ Supprimer</button>
                </form>
            </div>

        </div>

    </div>
</x-app-layout>
