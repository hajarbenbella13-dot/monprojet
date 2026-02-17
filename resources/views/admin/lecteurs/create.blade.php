<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-2xl text-indigo-600 leading-tight text-center uppercase tracking-widest">
            ✨ La Bibliothèque Magique ✨
        </h2>
    </x-slot>

    <div x-data="{ showRegister: false }" class="py-12 max-w-xl mx-auto px-4">
        
        @if (session('error'))
            <div class="bg-red-50 text-red-500 p-4 rounded-2xl mb-6 text-center font-black text-sm border-2 border-red-100 animate-bounce">
                {{ session('error') }} ❌
            </div>
        @endif

        <div class="bg-white shadow-2xl rounded-[3rem] p-8 md:p-12 border border-gray-100 relative">
            
            <div x-show="!showRegister" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95">
                <div class="text-center mb-10">
                    <div class="inline-block p-4 bg-indigo-50 rounded-full mb-4">
                        <span class="text-5xl">🔑</span>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 uppercase tracking-tighter">Je me connecte</h3>
                    <p class="text-gray-400 font-bold text-sm">Contant de te revoir !</p>
                </div>

                <form action="{{ route('lecteurs.checkPin') }}" method="POST" class="space-y-8 text-center">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-400 text-xs font-black uppercase tracking-[0.2em] mb-3">Ton joli prénom</label>
                        <input type="text" name="nom" required placeholder="Ex: Adam"
                               class="w-full bg-gray-50 border-none rounded-2xl p-5 text-xl font-bold text-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all text-center placeholder:text-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-gray-400 text-xs font-black uppercase tracking-[0.2em] mb-3">Ton Code PIN secret</label>
                        <input type="password" name="pin" maxlength="4" required placeholder="****"
                               class="w-full bg-gray-50 border-none rounded-2xl p-5 text-center text-3xl tracking-[0.5em] font-black text-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all shadow-sm">
                        <p class="text-[10px] text-gray-400 mt-2 italic">Tape tes 4 chiffres magiques</p>
                    </div>

                    <button type="submit" 
                    class="w-full bg-white text-indigo-600 border-2 border-indigo-100 font-black py-5 rounded-2xl text-xl shadow-xl shadow-indigo-50 hover:border-indigo-400 transition-all active:scale-95 uppercase tracking-widest">
                C'est parti ! 🚀
            </button>
                </form>

                <div class="mt-10 text-center border-t border-gray-50 pt-8">
                    <p class="text-gray-400 text-sm font-bold">Tu n'as pas encore de profil ?</p>
                    <button @click="showRegister = true" 
        class="bg-white text-indigo-600 font-black uppercase text-[11px] tracking-[0.2em] mt-4 px-8 py-3 rounded-full border-2 border-indigo-100 hover:border-indigo-400 hover:bg-indigo-50 transition-all shadow-sm">
    Créer mon compte ✨
</button>
                </div>
            </div>

            <div x-show="showRegister" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" style="display: none;">
                <div class="text-center mb-10">
                    <div class="inline-block p-4 bg-green-50 rounded-full mb-4">
                        <span class="text-5xl">🐣</span>
                    </div>
                    <h3 class="text-2xl font-black text-gray-800 uppercase tracking-tighter">Nouveau Lecteur</h3>
                    <p class="text-gray-400 font-bold text-sm">Crée ton profil en 2 secondes !</p>
                </div>

                <form action="{{ route('lecteurs.store') }}" method="POST" class="space-y-8 text-center">
                    @csrf
                    
                    <div>
                        <label class="block text-gray-400 text-xs font-black uppercase tracking-[0.2em] mb-3">Comment t'appelles-tu ?</label>
                        <input type="text" name="nom" required placeholder="Ex: Inès"
                               class="w-full bg-gray-50 border-none rounded-2xl p-5 text-xl font-bold text-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all text-center placeholder:text-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label class="block text-gray-400 text-xs font-black uppercase tracking-[0.2em] mb-3">Ton futur PIN (4 chiffres)</label>
                        <input type="text" name="pin" maxlength="4" required placeholder="1234"
                               class="w-full bg-gray-50 border-none rounded-2xl p-5 text-center text-xl tracking-widest font-black text-indigo-600 focus:ring-4 focus:ring-indigo-100 transition-all shadow-sm">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <label for="age25" class="relative cursor-pointer group">
                            <input type="radio" name="age_range" id="age25" value="2-5" class="peer hidden" required>
                            <div class="flex flex-col items-center justify-center p-6 bg-white border-4 border-gray-100 rounded-[2rem] transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 group-hover:bg-gray-50">
                                <span class="text-4xl mb-2">🐥</span>
                                <span class="text-sm font-black text-gray-600 uppercase">2-5 ans</span>
                            </div>
                        </label>
                        <label for="age610" class="relative cursor-pointer group">
                            <input type="radio" name="age_range" id="age610" value="6-10" class="peer hidden">
                            <div class="flex flex-col items-center justify-center p-6 bg-white border-4 border-gray-100 rounded-[2rem] transition-all peer-checked:border-indigo-500 peer-checked:bg-indigo-50 group-hover:bg-gray-50">
                                <span class="text-4xl mb-2">🦁</span>
                                <span class="text-sm font-black text-gray-600 uppercase">6-10 ans</span>
                            </div>
                        </label>
                    </div>

                    <button type="submit" 
                    class="w-full bg-white text-indigo-600 border-4 border-indigo-50 font-black py-5 rounded-2xl text-xl shadow-xl shadow-indigo-50 hover:border-indigo-200 transition-all active:scale-95 uppercase tracking-widest">
                Créer mon profil 🌟
            </button>

                    <button type="button" @click="showRegister = false" class="w-full text-gray-400 font-bold text-xs uppercase mt-4">
                        ← Revenir à la connexion
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>