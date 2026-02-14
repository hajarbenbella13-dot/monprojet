<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl">
            📖 {{ $livre->titre }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto">
        <div class="bg-white shadow-xl rounded-2xl p-8">

            @foreach($pages as $page)
                <div class="mb-6 p-4 border rounded-xl">
                    <h4 class="font-bold text-blue-600">
                        Page {{ $page->num_page }}
                    </h4>

                    <p class="mt-2 text-gray-700">
                        {{ $page->contenu }}
                    </p>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
