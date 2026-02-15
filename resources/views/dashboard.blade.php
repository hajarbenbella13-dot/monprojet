<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 py-2">
            <div>
                <h2 class="font-black text-3xl text-gray-800 leading-tight flex items-center gap-3">
                    <span class="text-4xl">📊</span> Tableau de Bord
                </h2>
                <p class="text-gray-500 text-sm font-medium mt-1 ml-1">Gérez votre bibliothèque et suivez l'activité des lecteurs.</p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('livres.create') }}" 
                   class="flex items-center px-5 py-3 bg-white text-gray-800 rounded-2xl text-xs font-black hover:bg-gray-50 transition shadow-sm border border-gray-200 group">
                    <span class="mr-2 group-hover:scale-125 transition-transform text-lg">➕</span>
                    NOUVEAU LIVRE
                </a>
            
                <a href="{{ route('livres.index') }}" 
                   class="flex items-center px-5 py-3 bg-indigo-600 text-gray-800 rounded-2xl text-xs font-black hover:bg-indigo-700 transition shadow-lg shadow-indigo-100 group">
                    <span class="mr-2 group-hover:rotate-12 transition-transform text-lg">📚</span>
                    BIBLIOTHÈQUE
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-4 max-w-7xl mx-auto">
        
        {{-- Alert Livres Vides --}}
        @if(isset($stats['livres_vides']) && $stats['livres_vides'] > 0)
        <div class="mb-8 p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-2xl flex items-center shadow-sm animate-pulse">
            <span class="mr-3 text-xl">⚠️</span>
            <p class="text-amber-800 text-sm font-medium">
                Attention: <strong>{{ $stats['livres_vides'] }}</strong> livre(s) n'ont pas encore de pages.
            </p>
        </div>
        @endif

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition">
                <div class="p-4 bg-blue-50 rounded-2xl text-2xl">👥</div>
                <div>
                    <p class="text-gray-400 text-xs font-black uppercase tracking-wider">Lecteurs Total</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_lecteurs'] }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition">
                <div class="p-4 bg-green-50 rounded-2xl text-2xl">📖</div>
                <div>
                    <p class="text-gray-400 text-xs font-black uppercase tracking-wider">Livres</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_livres'] }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4 hover:shadow-md transition">
                <div class="p-4 bg-purple-50 rounded-2xl text-2xl">📄</div>
                <div>
                    <p class="text-gray-400 text-xs font-black uppercase tracking-wider">Total Pages</p>
                    <h3 class="text-3xl font-black text-gray-800">{{ $stats['total_pages'] }}</h3>
                </div>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            {{-- Section Lecteurs --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 flex flex-col" x-data="{ showAll: false }">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black flex items-center text-gray-800">
                        <span class="p-2 bg-indigo-50 text-indigo-600 rounded-lg mr-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </span>
                        Les Lecteurs
                    </h3>
                </div>
                
                <div class="space-y-3 flex-grow">
                    @forelse($stats['recent_lecteurs'] as $index => $l)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-transparent hover:border-gray-200 hover:bg-white transition-all group"
                             x-show="showAll || {{ $index }} < 3">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-700 group-hover:text-indigo-600 transition-colors uppercase">
                                    {{ $l->nom }}
                                </span>
                                <span class="text-[10px] text-gray-400 font-medium uppercase">{{ $l->age }} ans</span>
                            </div>
                            
                            <a href="{{ route('lecteurs.show', $l->id) }}" 
                               class="text-[10px] font-black text-indigo-600 bg-white border border-indigo-100 px-4 py-2 rounded-xl group-hover:bg-indigo-600 group-hover:text-white transition-all uppercase">
                                Profil →
                            </a>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm italic text-center py-4">Il n'y a pas encore de lecteur.</p>
                    @endforelse
                </div>
                
                {{-- Hna fin l-bouton t-qaddat f l-west --}}
                @if(count($stats['recent_lecteurs']) > 3)
                    <div class="mt-6 pt-4 border-t border-gray-50 flex justify-center">
                        <button @click="showAll = !showAll" 
                                class="text-xs font-black text-gray-400 hover:text-indigo-600 transition-all uppercase tracking-widest flex items-center gap-2">
                            <span x-show="!showAll">↓ Voir tout ({{ count($stats['recent_lecteurs']) }})</span>
                            <span x-show="showAll">↑ Réduire</span>
                        </button>
                    </div>
                @endif
            </div>

            {{-- Section Livres Populaires --}}
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                <h3 class="text-xl font-black mb-6 flex items-center text-gray-800">
                    <span class="p-2 bg-amber-50 text-amber-600 rounded-lg mr-3">🔥</span>
                    Livres les plus lus
                </h3>
                <div class="space-y-6">
                    @forelse($popular_livres as $bl)
                    <div class="flex flex-col">
                        <div class="flex justify-between mb-2 items-center">
                            <span class="font-bold text-gray-700">{{ $bl->titre }}</span>
                            <span class="text-[10px] font-black bg-amber-100 text-amber-700 px-2 py-1 rounded-lg uppercase">
                                {{ $bl->progressions_count }} Lectures
                            </span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            @php
                                $percentage = $stats['total_lecteurs'] > 0 ? ($bl->progressions_count / $stats['total_lecteurs']) * 100 : 0;
                            @endphp
                            <div class="bg-gradient-to-r from-amber-300 to-amber-500 h-full rounded-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    @empty
                        <p class="text-gray-400 text-sm italic text-center py-4">Pas encore de données de lecture.</p>
                    @endforelse
                </div>
            </div>

        </div> {{-- Fin Grid --}}
    </div>
</x-app-layout>