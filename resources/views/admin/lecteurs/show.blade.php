<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl">
            👤 {{ $lecteur->nom }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto">
        <div class="bg-white shadow-xl rounded-2xl p-8">

            <h3 class="text-lg font-bold mb-6">
                📚 Mes Livres
            </h3>

            <div class="space-y-4">

                @foreach($livres as $livre)

                    <div class="p-4 border rounded-xl">

                        <a href="{{ route('lecteurs.readBook', [
        'lecteur' => $lecteur->id,
        'livre' => $livre->id
    ]) }}"
   class="text-blue-600 font-bold hover:underline">
    {{ $livre->titre }}
</a>

                        @if(isset($progressions[$livre->id]))

                            <p class="text-gray-600">
                                Dernière page :
                                <strong>
                                    {{ $progressions[$livre->id]->derniere_page }}
                                </strong>
                            </p>

                            <a href="{{ route('lecture.continuer', [
                                    'lecteur' => $lecteur->id,
                                    'livre' => $livre->id
                                ]) }}"
                               class="text-green-600 font-bold">
                                ▶️ Continuer la lecture
                            </a>

                        @endif

                        {{-- إذا ما عندوش progression --}}
                        @if(!isset($progressions[$livre->id]))
                            <p class="text-gray-400 italic">
                                Nouveau livre
                            </p>
                        @endif

                    </div>

                @endforeach

            </div>

        </div>
    </div>
</x-app-layout>
