<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Cours - Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
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
                                <i class="fas fa-book mr-3"></i> Liste des Cours
                            </a>
                        </li>
                        <li>
                            <a href="/professeurs/cours/sessions" class="sidebar-link flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-calendar-day mr-3"></i> Sessions
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

            <h1 class="text-4xl font-extrabold mb-8 text-center text-blue-600">Liste des Cours</h1>
            <div class="bg-white custom-shadow rounded-3xl overflow-hidden hover-scale transition-all">
                <!-- Formulaire de filtrage -->
                <div class="p-6 border-b border-blue-200 bg-gradient-to-r from-blue-50 to-gray-50">
                    <form action="/professeurs/cours" method="get" class="flex items-center space-x-4">
                        <input type="text" name="search" placeholder="Rechercher par libellé" value="<?= htmlspecialchars($search ?? '') ?>" class="p-4 border border-blue-300 rounded-xl w-full focus:ring-2 focus:ring-blue-500 transition-all" />
                        <button type="submit" class="bg-blue-600 text-white px-8 py-4 rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                            <i class="fas fa-search mr-2"></i> Rechercher
                        </button>
                    </form>
                </div>
                <!-- Liste des cours -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-blue-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="py-4 px-6 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">ID</th>
                                <th class="py-4 px-6 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Libellé</th>
                                <th class="py-4 px-6 text-left text-xs font-medium text-blue-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-blue-100">
                            <?php if (!empty($cours)) : ?>
                                <?php foreach ($cours as $course) : ?>
                                    <tr class="hover:bg-blue-50 transition-all">
                                        <td class="py-4 px-6 text-sm font-medium text-gray-900"><?= htmlspecialchars($course['id']) ?></td>
                                        <td class="py-4 px-6 text-sm text-gray-700"><?= htmlspecialchars($course['libelle']) ?></td>
                                        <td class="py-4 px-6 text-sm">
                                            <a href="/professeurs/cours/sessions/<?= htmlspecialchars($course['id']) ?>" class="text-blue-600 hover:text-blue-800 font-medium transition-all">
                                                <i class="fas fa-eye mr-2"></i> Voir Sessions
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="py-4 px-6 text-center text-gray-500">Aucun cours disponible.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="py-6 flex justify-center bg-blue-50">
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
        // JavaScript pour ajouter des animations et des interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Animation pour les cartes d'information
            const infoCard = document.querySelector('.hover-scale');
            infoCard.addEventListener('mouseover', function() {
                this.style.transform = 'scale(1.03)';
                this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
            });
            infoCard.addEventListener('mouseout', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '';
            });

            // Animation pour les liens de la sidebar
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('mouseover', function() {
                    this.style.paddingLeft = '24px';
                });
                link.addEventListener('mouseout', function() {
                    this.style.paddingLeft = '16px';
                });
            });

            // Animation pour les lignes du tableau
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseover', function() {
                    this.style.backgroundColor = '#EBF8FF';
                });
                row.addEventListener('mouseout', function() {
                    this.style.backgroundColor = '';
                });
            });
        });
    </script>
</body>

</html>