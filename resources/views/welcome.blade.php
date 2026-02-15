<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetitLecteur - Bienvenue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=bubblegum-sans:400" rel="stylesheet" />
    <style>
        .font-kids { font-family: 'Bubblegum Sans', cursive; }
        .gradient-bg { background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%); }
    </style>
</head>
<body class="gradient-bg antialiased">

    <nav class="p-6 flex justify-between items-center max-w-7xl mx-auto">
        <div class="flex items-center gap-2">
            <img src="{{ asset('logo.avif') }}" alt="Logo" style="height: 40px; width: auto;" class="rounded-lg shadow-sm">
            <span class="font-black text-2xl text-gray-800 tracking-tighter font-kids">
                Petit<span class="text-indigo-600">Lecteur</span>
            </span>
        </div>
        
       
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12 flex flex-col md:flex-row items-center justify-between">
        
        <div class="md:w-1/2 text-center md:text-left">
            <h1 class="text-5xl md:text-7xl font-bold text-indigo-900 mb-6 font-kids leading-tight">
                Une petite pause <br> <span class="text-orange-500">magique</span> avant de dormir
            </h1>
            
            <div class="bg-white/50 p-6 rounded-2xl border-l-4 border-indigo-500 mb-8 shadow-sm">
                <p class="text-xl text-gray-700 leading-relaxed italic">
                    "Parce que vos journées sont bien remplies, mais que le rituel de la lecture est sacré. PetitLecteur accompagne vos enfants dans leurs rêves les plus doux."
                </p>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                <a href="{{ url('/admin/lecteurs/create') }}" 
                   class="inline-block px-10 py-4 bg-orange-400 font-black text-2xl rounded-full shadow-lg hover:scale-105 transition-all duration-300"
                        style="color: #6d28d9 !important;">
                     Commencer l'aventure 🚀
                </a>
                <div class="flex items-center gap-2 text-gray-500">
                    <span>⭐ Histoires gratuites</span>
                    <span>🌙 Sommeil apaisé</span>
                </div>
            </div>
        </div>

        <div class="md:w-1/2 mt-12 md:mt-0 relative flex justify-center">
            <div class="relative group">
                
                <img src="{{ asset('logo.avif') }}" 
                     alt="Reading Kid" 
                     class="w-48 h-48 md:w-64 md:h-64 object-cover rounded-full border-4 border-white shadow-2xl brightness-75 group-hover:brightness-100 transition duration-300">
        
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-white font-bold text-xl md:text-2xl font-kids drop-shadow-lg text-center px-2">
                        Petit <br> Lecteur
                    </span>
                </div>
        
                <div class="absolute inset-0 bg-black/20 rounded-full"></div>
            </div>
        </div>
    </main>

    <footer class="text-center py-10 text-gray-400 text-sm">
        &copy; {{ date('Y') }} PetitLecteur - Fait avec ❤️ pour les petits lecteurs.
    </footer>

</body>
</html>