<x-guest-layout>
    <div class="flex flex-col items-center mb-6">
        <div class="relative">
            <img src="{{ asset('logo.avif') }}" 
                 class="w-24 h-24 md:w-28 md:h-28 object-cover rounded-full border-4 border-white shadow-xl" 
                 alt="Admin Logo">
            
        </div>
        
        <h1 class="mt-4 text-2xl font-black uppercase tracking-wider" style="color: #6d28d9;">
            Espace Admin
        </h1>
        <div class="h-1 w-10 bg-orange-400 rounded-full mt-1"></div>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="login" class="block font-bold text-indigo-900 mb-1 ml-1 text-sm uppercase">Identifiant</label>
            <x-text-input id="login" 
                class="block w-full !py-3 !rounded-2xl border-indigo-100 focus:border-orange-400 focus:ring-orange-400 shadow-sm" 
                type="text" name="login" :value="old('login')" required autofocus />
            <x-input-error :messages="$errors->get('login')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block font-bold text-indigo-900 mb-1 ml-1 text-sm uppercase">Mot de passe</label>
            <x-text-input id="password" 
                class="block w-full !py-3 !rounded-2xl border-indigo-100 focus:border-orange-400 focus:ring-orange-400 shadow-sm"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="w-5 h-5 rounded-full border-indigo-300 text-orange-500 shadow-sm focus:ring-orange-500" name="remember">
                <span class="ms-2 text-sm text-indigo-700 font-medium italic">Rester connecté</span>
            </label>
        </div>

        <div class="flex items-center justify-center pt-2">
            <button type="submit" 
                class="w-full py-4 bg-orange-400 hover:bg-orange-500 text-2xl font-black rounded-2xl shadow-lg hover:scale-[1.02] transition-all duration-300"
                style="color: #6d28d9 !important;">
                {{ __('Se Connecter') }} ⚡
            </button>
        </div>
    </form>
</x-guest-layout>