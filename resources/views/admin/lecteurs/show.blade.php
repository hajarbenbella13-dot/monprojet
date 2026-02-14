<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800">
            👤 Profil de : {{ $lecteur->nom }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto px-4">
        <div class="bg-white shadow-xl rounded-3xl p-8 border border-gray-100">

            <h3 class="text-2xl font-black mb-8 text-gray-700 flex items-center">
                <span class="mr-3">📚</span> Mes Livres
            </h3>

            <div class="grid gap-6">
                @foreach($livres as $livre)
                    @php
                        // جلب التقدم لهذا الكتاب
                        $progression = $progressions[$livre->id] ?? null;
                        
                        // حساب واش كمل الكتاب (آخر صفحة قراها == عدد صفحات الكتاب)
                        $isFinished = false;
                        if ($progression && $livre->pages->count() > 0) {
                            $maxPageNum = $livre->pages->max('num_page');
                            if ($progression->derniere_page >= $maxPageNum) {
                                $isFinished = true;
                            }
                        }
                    @endphp

                    <div class="p-6 border-2 {{ $isFinished ? 'border-green-100 bg-green-50/30' : 'border-gray-50 bg-white' }} rounded-2xl transition-all hover:shadow-md">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 mb-1">{{ $livre->titre }}</h4>
                                
                                @if($progression)
                                    <div class="flex items-center space-x-4 mt-2">
                                        <p class="text-sm text-gray-500">
                                            Statut: 
                                            @if($isFinished)
                                                <span class="text-green-600 font-bold uppercase text-xs tracking-widest">Terminé 🎉</span>
                                            @else
                                                <span class="text-blue-500 font-bold uppercase text-xs tracking-widest">En cours (P. {{ $progression->derniere_page }})</span>
                                            @endif
                                        </p>
                                    </div>
                                @else
                                    <p class="text-xs font-bold text-amber-500 uppercase tracking-widest mt-2">Nouveau livre ✨</p>
                                @endif
                            </div>

                            <div class="text-right">
                                @if($isFinished)
                                    <a href="{{ route('lecteurs.read', ['lecteur' => $lecteur->id, 'livre' => $livre->id, 'page' => 1]) }}" 
                                       class="inline-flex items-center px-6 py-2 bg-gray-800 text-white rounded-xl text-sm font-bold hover:bg-black transition shadow-sm">
                                        Relire 🔄
                                    </a>
                                @else
                                <a href="{{ route('lecteur.continuer', ['lecteur' => $lecteur->id, 'livre' => $livre->id]) }}" 
                                    class="inline-flex justify-center items-center px-8 py-3 bg-green-600 text-gray-800 rounded-xl text-sm font-black hover:bg-green-700 transition shadow-lg shadow-green-200">
                                     {{ $progression ? 'CONTINUER ▶️' : 'COMMENCER 📖' }}
                                 </a>
                                @endif
                                
                            </div>
                        </div>

                        @if($livre->pages->count() > 0)
                            <div class="mt-4 w-full bg-gray-100 rounded-full h-1.5">
                                @php 
                                    $currentPageNum = $progression ? $progression->derniere_page : 0;
                                    $totalPageNum = $livre->pages->max('num_page');
                                    $percent = ($currentPageNum / $totalPageNum) * 100;
                                @endphp
                                <div class="bg-{{ $isFinished ? 'green' : 'blue' }}-500 h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>