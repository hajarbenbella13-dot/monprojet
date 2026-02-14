<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('📚 Liste des Livres') }}
            </h2>
            <a href="{{ route('livres.create') }}" 
               class="flex items-center bg-white border border-gray-300 hover:border-gray-500 text-gray-600 px-4 py-2 rounded-lg text-sm font-bold transition-all shadow-sm">
                {{ __('+ Ajouter un Livre') }}
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full border-collapse table-fixed">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100 h-16">
                                <th class="w-16 p-3">
                                    <div class="flex justify-center items-center font-bold text-[10px] text-gray-500">ID</div>
                                </th>
                                <th class="w-20 p-3">
                                    <div class="flex justify-center items-center font-bold text-[10px] text-gray-500">Photo</div>
                                </th>
                                <th class="p-3">
                                    <div class="flex justify-center items-center font-bold text-[10px] text-gray-500">Titre</div>
                                </th>
                                <th class="w-24 p-3">
                                    <div class="flex justify-center items-center font-bold text-[10px] text-gray-500">Âge</div>
                                </th>
                                <th class="w-32 p-3">
                                    <div class="flex justify-center items-center font-bold text-[9px] text-blue-600 bg-blue-50/50 border-x border-gray-100">Action Pages</div>
                                </th>
                                <th class="w-32 p-3">
                                    <div class="flex justify-center items-center font-bold text-[9px] text-gray-500">Action Livre</div>
                                </th>
                            </tr>
                        </thead>
                    
                        <tbody class="divide-y divide-gray-100">
                            @forelse($livres as $index => $livre)
                                <tr class="h-16 hover:bg-gray-50/50 transition-colors">
                                    <!-- ID متسلسل -->
                                    <td>
                                        <div class="flex justify-center items-center text-xs text-gray-400 font-mono">#{{ $index + 1 }}</div>
                                    </td>
                        
                                    <!-- Photo -->
                                    <td>
                                        <div class="flex justify-center items-center h-full">
                                            @if($livre->photo)
                                                <img src="{{ asset('storage/' . $livre->photo) }}" class="w-8 h-8 rounded object-cover border border-gray-200 shadow-sm bg-white">
                                            @else
                                                <div class="w-8 h-8 bg-gray-50 rounded flex items-center justify-center text-gray-300 text-[7px] border border-dashed border-gray-200">N/A</div>
                                            @endif
                                        </div>
                                    </td>
                        
                                    <!-- Titre -->
                                    <td>
                                        <div class="flex justify-center items-center text-sm font-medium text-gray-700">
                                            {{ $livre->titre }}
                                        </div>
                                    </td>
                        
                                    <!-- Âge -->
                                    <td>
                                        <div class="flex justify-center items-center">
                                            <span class="inline-block bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded text-[10px] font-medium border border-indigo-100">
                                                {{ $livre->age_min }}-{{ $livre->age_max }}
                                            </span>
                                        </div>
                                    </td>
                        
                                    <!-- Action Pages -->
                                    <td>
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('livres.show', $livre->id) }}" class="p-1 text-blue-500 hover:bg-blue-50 rounded">👁</a>
                                            <a href="{{ route('pages.create', $livre->id) }}" class="p-1 text-emerald-500 hover:bg-emerald-50 rounded">➕</a>
                                        </div>
                                    </td>
                        
                                    <!-- Action Livre -->
                                    <td>
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('livres.edit', $livre->id) }}" class="p-1 text-amber-500 hover:bg-amber-50 rounded">✏️</a>
                                            <form action="{{ route('livres.destroy', $livre->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="p-1 text-red-400 hover:bg-red-50 rounded">🗑️</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-400">Aucun livre trouvé 📭</td>
                                </tr>
                            @endforelse
                        </tbody>
                        
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>