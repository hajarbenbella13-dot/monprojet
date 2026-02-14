<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                📖 {{ $livre->titre }}
            </h2>
            <a href="{{ route('lecteurs.show', $lecteur->id) }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-red-500 transition">
                Quitter
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto px-4">
        <div class="bg-white shadow-xl rounded-3xl p-6 md:p-10 border border-gray-100">

            <div class="mb-10">
                @php 
                    $totalDisplay = $pages->count();
                    $percentage = ($totalDisplay > 0) ? ($page / $totalDisplay) * 100 : 0;
                @endphp
                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                    <div class="bg-blue-600 h-full transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                </div>
            </div>

            @if($currentPage->image)
                <div class="mb-8">
                    <img src="{{ asset('storage/' . $currentPage->image) }}" 
                         class="w-full max-h-[250px] object-cover rounded-2xl shadow-sm border border-gray-50">
                </div>
            @endif

            @if($currentPage->audio)
                <div class="mb-8 bg-blue-50/50 p-3 rounded-xl border border-blue-100">
                    <audio controls class="w-full h-8">
                        <source src="{{ asset('storage/' . $currentPage->audio) }}" type="audio/mpeg">
                    </audio>
                </div>
            @endif

            <div class="mb-6">
                <div class="prose prose-blue max-w-none text-gray-800 text-xl leading-relaxed text-left">
                    {!! nl2br(e($currentPage->contenu)) !!}
                </div>
            </div>

            <div class="text-center mb-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-300">
                    Page {{ $currentPage->num_page }} / {{ $totalDisplay }}
                </p>
            </div>

            <div class="flex items-center gap-4">
                @php 
                    $prevPage = $pages->where('num_page', '<', $page)->last();
                    $nextPage = $pages->where('num_page', '>', $page)->first();
                @endphp

                <div class="flex-1">
                    @if($prevPage)
                        <a href="{{ route('lecteurs.read', [$lecteur->id, $livre->id, $prevPage->num_page]) }}"
                           class="flex justify-center items-center w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-sm hover:bg-blue-700 transition active:scale-95 shadow-md shadow-blue-100 uppercase tracking-wider">
                           ⬅️ Précédent
                        </a>
                    @else
                        <div class="w-full py-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200 text-center text-gray-300 text-xs font-bold uppercase tracking-widest">
                            Début
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    @if($nextPage)
                        <a href="{{ route('lecteurs.read', [$lecteur->id, $livre->id, $nextPage->num_page]) }}"
                           class="flex justify-center items-center w-full bg-blue-600 text-white py-4 rounded-2xl font-bold text-sm hover:bg-blue-700 transition active:scale-95 shadow-md shadow-blue-100 uppercase tracking-wider">
                           Suivant ➡️
                        </a>
                    @else
                        <button onclick="bravoAlert()" 
                           class="flex justify-center items-center w-full bg-green-500 text-white py-4 rounded-2xl font-bold text-sm hover:bg-green-600 transition shadow-md shadow-green-100 uppercase tracking-wider">
                           Terminer 🎉
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <script>
        function bravoAlert() {
            // تفركع الـ Confetti
            confetti({
                particleCount: 150,
                spread: 70,
                origin: { y: 0.6 }
            });

            // إظهار الرسالة
            Swal.fire({
                title: 'Bravo, {{ $lecteur->nom }} ! 🥳',
                text: 'Tu as terminé avec succès le livre : {{ $livre->titre }}',
                icon: 'success',
                confirmButtonText: 'Super !',
                confirmButtonColor: '#10B981',
                borderRadius: '20px',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('lecteurs.show', $lecteur->id) }}";
                }
            });
        }
    </script>
</x-app-layout>