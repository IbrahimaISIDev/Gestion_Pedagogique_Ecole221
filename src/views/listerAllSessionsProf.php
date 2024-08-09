<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sessions de Cours - Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f7ff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23d4e3f3' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M11 0l5 20H6l5-20zm42 31a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM0 72h40v4H0v-4zm0-8h31v4H0v-4zm20-16h20v4H20v-4zM0 56h40v4H0v-4zm63-25a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM53 41a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-30 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-28-8a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zM56 5a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zm-3 46a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM21 0l5 20H16l5-20zm43 64v-4h-4v4h-4v4h4v4h4v-4h4v-4h-4zM36 13h4v4h-4v-4zm4 4h4v4h-4v-4zm-4 4h4v4h-4v-4zm8-8h4v4h-4v-4z'/%3E%3C/g%3E%3C/svg%3E");
        }

        .transition-all {
            transition: all 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.03);
        }

        .sidebar-link {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #fff;
        }

        .custom-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="bg-blue-50 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-600 to-gray-500 text-white shadow-2xl">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-8 text-center">Menu</h2>
                <nav>
                    <ul class="space-y-4">
                        <li>
                            <a href="/professeurs/cours" class="sidebar-link flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-book mr-3"></i> Mes Cours
                            </a>
                        </li>
                        <li>
                            <a href="/professeurs/cours/sessions" class="sidebar-link flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-chalkboard-teacher mr-3"></i> Sessions
                            </a>
                        </li>
                        <li>
                            <a href="/professeurs/calendrier-hebdomadaire" class="sidebar-link flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-calendar-day mr-3"></i> Calendrier
                            </a>
                        </li>
                        <li>
                            <a href="/professeurs/annulations" class="sidebar-link flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-exclamation-triangle mr-3"></i> Demandes d'Annulation
                            </a>
                        </li>
                        <li>
                            <a href="/logout" class="sidebar-link flex items-center py-3 px-4 text-red-300 hover:bg-red-600 hover:text-white rounded-lg mt-8">
                                <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="bg-white custom-shadow rounded-3xl overflow-hidden p-8 mb-8 hover-scale transition-all">
                <h2 class="text-3xl font-semibold mb-6 text-blue-600">Informations du Professeur</h2>
                <div class="flex items-center p-6 border border-blue-200 rounded-2xl shadow-lg bg-gradient-to-r from-blue-50 to-gray-50">
                    <div class="bg-blue-200 rounded-full p-4">
                        <i class="fas fa-user-tie text-blue-600 text-4xl"></i>
                    </div>
                    <div class="ml-6">
                        <p class="text-xl font-medium text-gray-800"><span class="text-blue-600">Nom:</span> <?= htmlspecialchars($professeur['nom']) ?></p>
                        <p class="text-xl font-medium text-gray-800"><span class="text-blue-600">Prénom:</span> <?= htmlspecialchars($professeur['prenom']) ?></p>
                        <p class="text-xl font-medium text-gray-800"><span class="text-blue-600">Email:</span> <?= htmlspecialchars($professeur['email']) ?></p>
                    </div>
                </div>
            </div>

            <h1 class="text-4xl font-extrabold mb-8 text-center text-blue-600">Liste des Sessions de Cours</h1>

            <form action="" method="GET" class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 p-8 rounded-xl shadow-2xl">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 items-end">
                    <div class="space-y-2">
                        <label for="search" class="block text-sm font-semibold text-gray-700">Recherche</label>
                        <div class="relative">
                            <input type="text" id="search" name="search" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>" class="w-full p-3 pl-10 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-300 ease-in-out shadow-sm">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.293 12.293a1 1 0 011.414 1.414l-3.397 3.397a8 8 0 111.415-1.415l3.397-3.397zM8 14a6 6 0 100-12 6 6 0 000 12z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="date_filter" class="block text-sm font-semibold text-gray-700">Date</label>
                        <input type="date" id="date_filter" name="date_filter" value="<?= htmlspecialchars($dateFilter) ?>" class="w-full p-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-300 ease-in-out shadow-sm">
                    </div>
                    <div class="space-y-2">
                        <label for="statut_filter" class="block text-sm font-semibold text-gray-700">Statut</label>
                        <select id="statut_filter" name="statut_filter" class="w-full p-3 border-2 border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-300 ease-in-out shadow-sm appearance-none bg-white">
                            <option value="">Tous les statuts</option>
                            <option value="planifiée" <?= $statutFilter === 'planifiée' ? 'selected' : '' ?>>Planifiée</option>
                            <option value="annulée" <?= $statutFilter === 'annulée' ? 'selected' : '' ?>>Annulée</option>
                        </select>
                    </div>
                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300 ease-in-out shadow-md transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Filtrer
                        </button>
                        <button type="submit" name="reset" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition duration-300 ease-in-out shadow-md transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Réinitialiser
                        </button>
                    </div>
                </div>
            </form>



            <!-- Tableau des sessions -->
            <div class="bg-white custom-shadow rounded-3xl overflow-hidden hover-scale transition-all">
                <!-- Liste des sessions -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-blue-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <!-- <th class="py-4 px-6 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">ID</th> -->
                                <th class="py-4 px-6 text-left text-lg font-semibold text-blue-600 uppercase tracking-wider">Libellé du Cours</th>
                                <th class="py-4 px-6 text-left text-lg font-semibold text-blue-600 uppercase tracking-wider">Date</th>
                                <th class="py-4 px-6 text-left text-lg font-semibold text-blue-600 uppercase tracking-wider">Heure Début</th>
                                <th class="py-4 px-6 text-left text-lg font-semibold text-blue-600 uppercase tracking-wider">Heure Fin</th>
                                <th class="py-4 px-6 text-left text-lg font-semibold text-blue-600 uppercase tracking-wider">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-blue-100">
                            <?php if (!empty($sessions)) : ?>
                                <?php foreach ($sessions as $session) : ?>
                                    <tr class="hover:bg-blue-50 transition-all">
                                        <!-- <td class="py-4 px-6 text-sm font-medium text-gray-900"><?= htmlspecialchars($session['id']) ?></td> -->
                                        <td class="py-4 px-6 text-sm font-medium text-gray-700"><i class="fas fa-book mr-2"></i><?= htmlspecialchars($session['libelle_cours']) ?></td>
                                        <td class="py-4 px-6 text-sm font-medium text-gray-700"><?= htmlspecialchars($session['date']) ?></td>
                                        <td class="py-4 px-6 text-sm font-medium text-gray-700"><?= htmlspecialchars($session['heure_debut']) ?></td>
                                        <td class="py-4 px-6 text-sm font-medium text-gray-700"><?= htmlspecialchars($session['heure_fin']) ?></td>
                                        <td class="py-4 px-6 text-sm font-medium text-gray-700"><?= htmlspecialchars($session['statut']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="6" class="py-4 px-6 text-center text-gray-500">Aucune session de cours trouvée.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="py-6 flex justify-center bg-blue-50">
                <?php
                    // Initialize $currentPage and other variables if not set
                    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    ?>
                    <nav class="flex space-x-2">
                        <?php if ($currentPage > 1) : ?>
                            <a href="?page=1&search=<?= htmlspecialchars($search) ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all">1</a>
                            <a href="?page=<?= $currentPage - 1 ?>&search=<?= htmlspecialchars($search) ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all">Précédent</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                            <a href="?page=<?= $i ?>&search=<?= htmlspecialchars($search) ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all <?= $i === $currentPage ? 'bg-blue-800' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($currentPage < $totalPages) : ?>
                            <a href="?page=<?= $currentPage + 1 ?>&search=<?= htmlspecialchars($search) ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all">Suivant</a>
                            <a href="?page=<?= $totalPages ?>&search=<?= htmlspecialchars($search) ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all"><?= $totalPages ?></a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetButton = document.getElementById('resetButton');
            const filterForm = document.getElementById('filterForm');

            resetButton.addEventListener('click', function() {
                // Réinitialiser les champs du formulaire
                filterForm.reset();

                // Optionnel : Si vous voulez aussi effacer les paramètres de l'URL
                window.location.href = window.location.pathname;
            });
        });
    </script>
</body>

</html>