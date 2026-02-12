<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Liste des Livres') }}
            </h2>
            
            <a href="{{ route('livres.create') }}" 
               style="background-color: #2563eb; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; text-decoration: none; display: inline-block;">
                + Ajouter un Livre
            </a>
        </div>
    </x-slot>
    @if(session('success'))
    <div style="background-color: #d1fae5; color: #065f46; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        {{ session('success') }}
    </div>
@endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shadow-md">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b">
                                <th class="p-4 font-bold uppercase text-sm text-gray-600">ID</th>
                                <th class="p-4 font-bold uppercase text-sm text-gray-600">Photo</th>
                                <th class="p-4 font-bold uppercase text-sm text-gray-600">Titre</th>
                                <th class="p-4 font-bold uppercase text-sm text-gray-600">Audio</th>
                                <th class="p-4 font-bold uppercase text-sm text-gray-600">Description</th>
                                <th class="p-4 font-bold uppercase text-sm text-gray-600 text-center">Âge</th>
                                <th class="p-4 font-bold uppercase text-sm text-gray-600 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($livres as $livre)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4">{{ $livre->id }}</td>
                                    <td class="p-4">
                                        @if($livre->photo)
                                            <img src="{{ asset('storage/' . $livre->photo) }}" alt="Photo" class="w-12 h-12 rounded shadow-sm object-cover">
                                        @else
                                            <span class="text-gray-400 text-xs italic">Aucune</span>
                                        @endif
                                    </td>
                                    <td class="p-4 font-medium">{{ $livre->titre }}</td>
                                    <td class="p-4 text-sm">
                                        @if($livre->audio)
                                            <span class="text-green-600">🎵 Audio OK</span>
                                        @else
                                            <span class="text-red-400">❌ Aucun</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600 max-w-xs truncate">{{ $livre->description }}</td>
                                    <td class="p-4 text-center">
                                        <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs">
                                            {{ $livre->age_min }} - {{ $livre->age_max }} ans
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('livres.edit', $livre->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">Modifier</a>
                                            <form action="{{ route('livres.destroy', $livre->id) }}" method="POST" onsubmit="return confirm('Etes-vous sûr ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-10 text-center text-gray-500 font-semibold">
                                        Aucun livre trouvé dans la base de données.
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