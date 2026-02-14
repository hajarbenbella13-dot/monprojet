<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center" style="display:flex; justify-content:space-between; align-items:center;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Ajouter des Pages au Livre : <span class="text-blue-600">{{ $livre->titre }}</span>
            </h2>
            <a href="{{ route('livres.index') }}" style="color: #4b5563; font-weight: bold;">← Retour</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if ($errors->any())
                <div style="background-color: #fca5a5; color: #7f1d1d; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f87171;">
                    <strong style="display: block; margin-bottom: 5px;">🚨  Oups ! Il y a un problème :</strong>
                    <ul style="list-style-type: disc; margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Message de succès --}}
            @if(session('success'))
                <div style="background-color: #d1fae5; color: #065f46; padding: 15px; margin-bottom: 20px; border-radius: 8px;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Formulaire --}}
            <div class="bg-white p-8 shadow-sm sm:rounded-lg border-t-4 border-blue-500">
                <form 
                    action="{{ isset($editingPage) ? route('pages.update', $editingPage->id) : route('pages.store', $livre->id) }}" 
                    method="POST" 
                    enctype="multipart/form-data"
                >
                    @csrf
                    @if(isset($editingPage))
                        @method('PUT')
                    @endif
            
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Numéro de Page</label>
                            <input type="number" name="num_page" 
                                   value="{{ old('num_page', $editingPage->num_page ?? '') }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
            
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Audio de la Page</label>
                            <input type="file" name="audio" class="w-full border-gray-300 rounded-md shadow-sm">
                            @if(isset($editingPage) && $editingPage->audio)
                                <small class="text-xs text-green-600">🎵 Audio actuel disponible</small>
                            @endif
                        </div>
            
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Image de la Page</label>
                            <input type="file" name="image" class="w-full" {{ isset($editingPage) ? '' : 'required' }}>
                            @if(isset($editingPage) && $editingPage->image)
                                <img src="{{ asset('storage/' . $editingPage->image) }}" class="w-16 h-16 object-cover rounded mt-1">
                            @endif
                        </div>
            
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Contenu (Texte)</label>
                            <textarea name="contenu" rows="5" 
                                      class="w-full border-gray-300 rounded-md shadow-sm p-2 text-sm" 
                                      required>{{ old('contenu', $editingPage->contenu ?? '') }}</textarea>
                            
                        </div>
            
                    </div>
            
                    <div style="margin-top: 20px;">
                        <button type="submit" 
                                style="background-color: #2563eb; color: white; padding: 12px; width: 100%; border-radius: 6px; font-weight: bold; cursor: pointer;">
                            {{ isset($editingPage) ? '✏️ Modifier la Page' : '➕ Ajouter la Page' }}
                        </button>
                    </div>
                </form>
            </div>
            

            {{-- Liste des Pages --}}
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-bold text-gray-700 mb-4 text-sm">📖 Pages actuelles ({{ $livre->pages->count() }})</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 10px;">
                    @forelse($livre->pages->sortBy('num_page') as $page)
                        <div class="border rounded p-1 text-center shadow-sm text-[11px]">
            
                            {{-- Image --}}
                            <img src="{{ asset('storage/' . $page->image) }}" class="w-full h-20 object-cover rounded mb-1">
            
                            {{-- Page Number --}}
                            <div class="font-bold mb-1">Page {{ $page->num_page }}</div>
            
                            {{-- Audio --}}
                            @if($page->audio)
                                <div class="text-xs text-green-600 mb-1">🎵</div>
                            @endif
            
                            {{-- Buttons Voir / Modifier / Supprimer --}}
                            <div class="flex justify-center gap-1">
                                <a href="{{ route('pages.show', $page->id) }}" class="p-1 bg-blue-500 text-white rounded text-[9px] hover:bg-blue-600" title="Voir">🔍</a>
                                <a href="{{ route('pages.create', ['livre' => $livre->id, 'edit' => $page->id]) }}" ...>✏️</a>

                                <form action="{{ route('pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Supprimer cette page ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1 bg-red-600 text-white rounded text-[9px] hover:bg-red-700" title="Supprimer">🗑️</button>
                                </form>
                            </div>
            
                        </div>
                    @empty
                        <p style="grid-column: 1 / -1; text-align: center; color: #9ca3af; padding: 15px; font-size: 12px;">
                            Aucune page ajoutée pour le moment.
                        </p>
                    @endforelse
                </div>
            </div>
            
            
            
    </div>
</x-app-layout>