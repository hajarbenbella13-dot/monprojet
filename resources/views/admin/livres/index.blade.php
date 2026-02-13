<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('📚 Liste des Livres') }}
            </h2>
            
            {{-- Bouton Ajouter passé en Gris --}}
            <a href="{{ route('livres.create') }}" 
            class="flex items-center bg-white border-2 border-gray-300 hover:border-gray-500 text-gray-600 hover:text-gray-800 px-5 py-2 rounded-lg font-bold transition-all duration-200 shadow-sm">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
             </svg>
             {{ __('Ajouter un Livre') }}
         </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="max-w-7xl mx-auto mt-6 px-6 lg:px-8">
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="p-4 font-bold uppercase text-xs text-gray-600">ID</th>
                                <th class="p-4 font-bold uppercase text-xs text-gray-600">Photo</th>
                                <th class="p-4 font-bold uppercase text-xs text-gray-600">Titre</th>
                                <th class="p-4 font-bold uppercase text-xs text-gray-600 text-center">Âge</th>
                                <th class="p-4 font-bold uppercase text-xs text-gray-600 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($livres as $livre)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4 text-sm text-gray-500">#{{ $livre->id }}</td>
                                    <td class="p-4">
                                        @if($livre->photo)
                                            {{-- Image de taille moyenne --}}
                                            <img src="{{ asset('storage/' . $livre->photo) }}" alt="Photo" class="w-16 h-16 rounded shadow-sm object-cover border">
                                        @else
                                            <div class="w-16 h-16 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-[10px]">N/A</div>
                                        @endif
                                    </td>
                                    <td class="p-4 font-semibold text-gray-800">{{ $livre->titre }}</td>
                                    
                                    <td class="p-4 text-center">
                                        <span class="bg-indigo-50 text-indigo-700 px-2 py-1 rounded-full text-xs font-medium border border-indigo-100">
                                            {{ $livre->age_min }} - {{ $livre->age_max }} ans
                                        </span>
                                    </td>
                                    <td class="p-4 text-right">
                                        <div class="flex justify-end items-center space-x-4">
                                            
                                            {{-- Bouton Ajouter Page --}}
                                            <a href="{{ route('pages.create', $livre->id) }}" class="text-green-600 hover:text-green-800" title="Ajouter une page">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </a>

                                            {{-- Bouton Modifier --}}
                                            <a href="{{ route('livres.edit', $livre->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Modifier le livre">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            {{-- Bouton Supprimer --}}
                                            <form action="{{ route('livres.destroy', $livre->id) }}" method="POST" onsubmit="return confirm('Supprimer ce livre ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 pt-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m4-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-10 text-center text-gray-400 italic">
                                        Aucun livre disponible.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>