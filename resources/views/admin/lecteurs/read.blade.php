<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                📖 {{ $livre->titre }}
            </h2>
            <a href="{{ route('lecteurs.show', $lecteur->id) }}" class="text-xs font-black uppercase tracking-widest text-gray-400 hover:text-red-500 transition border-b-2 border-transparent hover:border-red-500 pb-1">
                Quitter ✖
            </a>
        </div>
    </x-slot>

    <div class="py-10 max-w-4xl mx-auto px-4">
        <div class="bg-white shadow-xl rounded-3xl p-6 md:p-10 border border-gray-100">

            {{-- Progress Bar --}}
            <div class="mb-10">
                @php 
                    // Kan-akhdo ga3 l-pages dyal l-livre mn l-base de données
                    $allPages = \App\Models\Page::where('livre_id', $livre->id)->orderBy('num_page')->get();
                    $totalDisplay = $allPages->count();
                    $currentNum = $currentPage->num_page;
                    $percentage = ($totalDisplay > 0) ? ($currentNum / $totalDisplay) * 100 : 0;
                @endphp
                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden shadow-inner">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-full transition-all duration-1000 ease-out" style="width: {{ $percentage }}%"></div>
                </div>
            </div>

            {{-- Image dyal l-page --}}
            @if($currentPage->image)
                <div class="mb-8">
                    <img src="{{ asset('storage/' . $currentPage->image) }}" 
                         class="w-full max-h-[400px] object-contain rounded-3xl shadow-lg border border-gray-50 bg-gray-50">
                </div>
            @endif

            {{-- Audio dyal l-page --}}
            @if($currentPage->audio)
                <div class="mb-8 bg-indigo-50/50 p-4 rounded-2xl border border-indigo-100 flex items-center space-x-4">
                    <span class="text-2xl">🔊</span>
                    <audio controls class="w-full h-10 custom-audio">
                        <source src="{{ asset('storage/' . $currentPage->audio) }}" type="audio/mpeg">
                    </audio>
                </div>
            @endif

            {{-- Contenu --}}
            <div class="mb-10">
                <div class="prose prose-indigo max-w-none text-gray-800 text-2xl leading-relaxed text-left font-medium">
                    {!! nl2br(e($currentPage->contenu)) !!}
                </div>
            </div>

            {{-- Page Number --}}
            <div class="text-center mb-10 border-t border-gray-50 pt-6">
                <p class="text-[11px] font-black uppercase tracking-[0.3em] text-gray-400 bg-gray-50 inline-block px-4 py-1 rounded-full">
                    Page {{ $currentPage->num_page }} sur {{ $totalDisplay }}
                </p>
            </div>

            {{-- Navigation Buttons --}}
            <div class="flex items-center gap-4">
                <div class="flex-1">
                    @if($prevPage)
                        <a href="{{ route('lecteurs.read', [$lecteur->id, $livre->id, $prevPage->num_page]) }}"
                           class="flex justify-center items-center w-full bg-white border-2 border-gray-100 text-gray-700 py-4 rounded-2xl font-black text-sm hover:border-blue-400 hover:text-blue-600 transition active:scale-95 shadow-sm uppercase tracking-wider">
                            ⬅️ Précédent
                        </a>
                    @else
                        <div class="w-full py-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200 text-center text-gray-300 text-xs font-bold uppercase tracking-widest opacity-50">
                            Première Page
                        </div>
                    @endif
                </div>

                <div class="flex-1">
                    @if($nextPage)
                        <a href="{{ route('lecteurs.read', [$lecteur->id, $livre->id, $nextPage->num_page]) }}"
                           class="flex justify-center items-center w-full bg-indigo-600 text-white py-4 rounded-2xl font-black text-sm hover:bg-indigo-700 transition active:scale-95 shadow-lg shadow-indigo-100 uppercase tracking-wider">
                            Suivant ➡️
                        </a>
                    @else
                        <button onclick="bravoAlert()" 
                            class="flex justify-center items-center w-full bg-green-500 text-white py-4 rounded-2xl font-black text-sm hover:bg-green-600 transition shadow-lg shadow-green-100 uppercase tracking-wider animate-bounce">
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
            // Effet Confetti
            var duration = 3 * 1000;
            var end = Date.now() + duration;

            (function frame() {
              confetti({
                particleCount: 3,
                angle: 60,
                spread: 55,
                origin: { x: 0 },
                colors: ['#6366f1', '#10b981', '#f59e0b']
              });
              confetti({
                particleCount: 3,
                angle: 120,
                spread: 55,
                origin: { x: 1 },
                colors: ['#6366f1', '#10b981', '#f59e0b']
              });

              if (Date.now() < end) {
                requestAnimationFrame(frame);
              }
            }());

            // SweetAlert
            Swal.fire({
                title: 'Bravo, {{ $lecteur->nom }} ! 🏆',
                text: 'Tu as terminé la lecture de : {{ $livre->titre }}',
                icon: 'success',
                confirmButtonText: 'RETOUR AU PROFIL',
                confirmButtonColor: '#4f46e5',
                padding: '2rem',
                background: '#fff',
                borderRadius: '2rem',
                allowOutsideClick: false,
                customClass: {
                    title: 'font-black text-2xl',
                    confirmButton: 'rounded-xl font-bold px-8 py-3'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('lecteurs.show', $lecteur->id) }}";
                }
            });
        }
    </script>
</x-app-layout>