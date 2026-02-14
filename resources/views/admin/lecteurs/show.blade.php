<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl">Lecteur: {{ $lecteur->nom }}</h2>
    </x-slot>

    <div class="py-12 max-w-4xl mx-auto space-y-4">
        <p>Age: {{ $lecteur->age }} ans</p>

        <h3 class="font-semibold text-lg mt-4">Livres en cours:</h3>
        <div class="grid grid-cols-2 gap-4">
            @forelse($progressions as $prog)
                <a href="{{ route('lecteur.livre.show', $prog->livre->id) }}"
                   class="block p-4 bg-white shadow rounded hover:shadow-md">
                    <div class="font-bold">{{ $prog->livre->titre }}</div>
                    <div>Dernière page: {{ $prog->derniere_page }}</div>
                </a>
            @empty
                <p>Aucun livre en cours pour ce lecteur.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
