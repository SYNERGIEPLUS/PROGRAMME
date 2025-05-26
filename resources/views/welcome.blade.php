<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue - Institut Géographique du Burkina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CSS (optionnel) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="text-center">
            <h1 class="text-4xl font-bold mb-4">Bienvenue à l'application de gestion des programmes</h1>
            <p class="mb-6">AGP - Burkina</p>

            <div class="space-x-4">
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
                    Se connecter
                </a>
                <a href="{{ route('register') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded">
                    S'inscrire
                </a>
            </div>
        </div>
    </div>

</body>
</html>
