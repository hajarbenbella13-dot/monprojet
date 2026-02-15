<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-indigo-600 leading-tight text-center">
            🚀 Commencer l'aventure
        </h2>
    </x-slot>

    <div class="py-12 max-w-xl mx-auto px-4">
        <div class="bg-white shadow-2xl rounded-[3rem] p-8 md:p-12 border border-gray-100">
            
            <div class="text-center mb-10">
                <p class="text-gray-500 font-bold text-lg">Crée ton profil pour commencer à lire !</p>
            </div>

            <form action="{{ route('lecteurs.store') }}" method="POST" class="space-y-8">
                @csrf
                
                {{-- Input dyal Smiya --}}
                <div>
                    <label class="block text-gray-400 text-xs font-black uppercase tracking-[0.2em] mb-3 ml-2">Ton joli prénom</label>
                    <input type="text" name="nom" required placeholder="Ex: Adam"
                           class="w-full bg-gray-50 border-none rounded-2xl p-5 text-xl font-bold text-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all placeholder:text-gray-300">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <label for="age25" class="relative cursor-pointer group">
                        <input type="radio" name="age_range" id="age25" value="2-5" class="peer hidden" required>
                        <div class="flex flex-col items-center justify-center p-6 bg-white border-4 border-gray-100 rounded-[2rem] transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 group-hover:bg-gray-50 shadow-sm">
                            <span class="text-4xl mb-2">🐥</span>
                            <span class="text-sm font-black text-gray-600 uppercase">2-5 ans</span>
                        </div>
                    </label>
                
                    <label for="age610" class="relative cursor-pointer group">
                        <input type="radio" name="age_range" id="age610" value="6-10" class="peer hidden">
                        <div class="flex flex-col items-center justify-center p-6 bg-white border-4 border-gray-100 rounded-[2rem] transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 group-hover:bg-gray-50 shadow-sm">
                            <span class="text-4xl mb-2">🦁</span>
                            <span class="text-sm font-black text-gray-600 uppercase">6-10 ans</span>
                        </div>
                    </label>
                </div>

                <div class="pt-4">
                    <button type="submit"
                            class="w-full bg-indigo-600 text-gray-600 font-black py-5 rounded-2xl text-xl shadow-xl shadow-indigo-100 hover:bg-indigo-700 hover:-translate-y-1 transition-all active:scale-95 uppercase tracking-tighter">
                        C'est parti ! 🚀
                    </button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>