<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Ecole 221</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f7ff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23d4e3f3' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M11 0l5 20H6l5-20zm42 31a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM0 72h40v4H0v-4zm0-8h31v4H0v-4zm20-16h20v4H20v-4zM0 56h40v4H0v-4zm63-25a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM53 41a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-30 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-28-8a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zM56 5a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zm-3 46a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM21 0l5 20H16l5-20zm43 64v-4h-4v4h-4v4h4v4h4v-4h4v-4h-4zM36 13h4v4h-4v-4zm4 4h4v4h-4v-4zm-4 4h4v4h-4v-4zm8-8h4v4h-4v-4z'/%3E%3C/g%3E%3C/svg%3E");
        }
        h1, h2 {
            font-family: 'Playfair Display', serif;
        }
        .custom-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="bg-blue-50 font-sans">

    <!-- Section de connexion avec en-tête -->
    <section class="flex items-center justify-center min-h-screen py-8 px-4">
        <div class="relative w-full max-w-md mx-auto bg-white custom-shadow rounded-3xl overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-gray-700"></div>
            <div class="relative z-10 px-8 py-10">
                <!-- En-tête dans la section -->
                <div class="text-center mb-8">
                    <h1 class="text-5xl font-extrabold text-white mb-2">Ecole 221</h1>
                    <p class="text-xl text-blue-200">Votre plateforme de gestion éducative</p>
                </div>
                <h2 class="text-3xl font-bold text-white mb-6 text-center">Se Connecter</h2>

                <!-- Affichage des messages d'erreur -->
                <?php if (!empty($error)) : ?>
                    <div class="mb-6 p-4 bg-red-100 text-red-700 border border-red-300 rounded-lg">
                        <p><?= htmlspecialchars($error) ?></p>
                    </div>
                <?php endif; ?>

                <form action="/login" method="POST" class="space-y-6">
                    <div>
                        <label for="email" class="block text-white font-medium mb-1">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </span>
                            <input type="email" id="email" name="email" placeholder="Votre email" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block text-white font-medium mb-1">Mot de passe</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="fas fa-lock text-gray-400"></i>
                            </span>
                            <input type="password" id="password" name="password" placeholder="Votre mot de passe" class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember-me" name="remember-me" class="w-4 h-4 text-blue-600 bg-gray-800 rounded focus:ring-blue-500">
                            <label for="remember-me" class="ml-2 text-white">Se souvenir de moi</label>
                        </div>
                        <a href="#" class="text-blue-200 hover:text-blue-100">Mot de passe oublié ?</a>
                    </div>
                    <button type="submit" class="w-full py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200 ease-in-out">
                        <i class="fas fa-sign-in-alt mr-2"></i> Se Connecter
                    </button>
                </form>
            </div>
        </div>
    </section>

</body>

</html>