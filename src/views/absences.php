<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absences - Étudiant</title>
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

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 0.5rem;
            padding: 2rem;
            width: 90%;
            max-width: 500px;
        }

        .modal.show {
            display: flex;
        }
    </style>
</head>

<body>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-600 to-gray-500 text-white shadow-2xl">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-8 text-center">Menu</h2>
                <nav>
                    <ul class="space-y-4">
                        <li>
                            <a href="/etudiants/emploi_du_temps" class="sidebar-link flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-calendar-alt mr-3"></i> Emploi du Temps
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/cours" class="sidebar-link flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-book mr-3"></i> Liste des Cours
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/absences" class="sidebar-link flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-calendar-times mr-3"></i> Liste des Absences
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/calendrier" class="sidebar-link flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-calendar-alt mr-3"></i> Calendrier des Sessions
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
                <h2 class="text-3xl font-semibold mb-6 text-blue-600">Informations de l'Étudiant</h2>
                <!-- Affichage des informations de l'étudiant -->
                <div class="flex items-center p-6 border border-blue-200 rounded-2xl shadow-lg bg-gradient-to-r from-blue-50 to-gray-50">
                    <div class="bg-blue-200 rounded-full p-4">
                        <i class="fas fa-user-graduate text-blue-600 text-4xl"></i>
                    </div>
                    <div class="ml-6">
                        <p class="text-xl font-medium text-gray-800"><span class="text-blue-600">Nom:</span> <?= htmlspecialchars($etudiant['nom']) ?></p>
                        <p class="text-xl font-medium text-gray-800"><span class="text-blue-600">Prénom:</span> <?= htmlspecialchars($etudiant['prenom']) ?></p>
                        <p class="text-xl font-medium text-gray-800"><span class="text-blue-600">Email:</span> <?= htmlspecialchars($etudiant['email']) ?></p>
                        <p class="text-xl font-medium text-gray-800"><span class="text-blue-600">Niveau:</span> <?= htmlspecialchars($etudiant['niveau']) ?></p>
                    </div>
                    <!-- <div class="text-right">
                        <p class="text-xl font-medium text-gray-800"><span class="text-blue-600">Année Scolaire:</span> <?= htmlspecialchars($anneeScolaire) ?></p>
                        <p class="text-xl font-medium text-gray-800"><span class="text-blue-600">Semestre:</span> <?= htmlspecialchars($semestre) ?></p>
                    </div> -->
                </div>
            </div>

            <h1 class="text-4xl font-extrabold mb-8 text-center text-blue-600">Absences</h1>

            <div class="bg-white custom-shadow rounded-3xl overflow-hidden hover-scale transition-all">
                <!-- Liste des absences -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-blue-200">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="py-4 px-6 text-left text-sm font-medium text-blue-600 uppercase tracking-wider">Date</th>
                                <th class="py-4 px-6 text-left text-sm font-medium text-blue-600 uppercase tracking-wider">Cours</th>
                                <th class="py-4 px-6 text-left text-sm font-medium text-blue-600 uppercase tracking-wider">Statut</th>
                                <th class="py-4 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                <th class="py-4 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Etat</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-blue-100">
                            <?php if (!empty($absences)) : ?>
                                <?php foreach ($absences as $absence) : ?>
                                    <tr>
                                        <td class="py-4 px-6 text-sm text-gray-700"><?= htmlspecialchars($absence['date_absence']) ?></td>
                                        <td class="py-4 px-6 text-sm text-gray-700"><?= htmlspecialchars($absence['cours_libelle']) ?></td>
                                        <td class="py-4 px-6 text-sm">
                                            <form action="/etudiants/absences" method="post" class="inline">
                                                <input type="hidden" name="absence_id" value="<?= $absence['id'] ?>">
                                                <?php if (!isset($absence['justification_id'])) : ?>
                                                    <button type="submit" name="statut" value="justifie" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all">Non Justifié</button>
                                                <?php else : ?>
                                                    <span class="text-green-600">Justifié</span>
                                                <?php endif; ?>
                                            </form>
                                        </td>
                                        <td class="py-4 px-6 text-sm">
                                            <?php if (isset($absence['justification_id'])) : ?>
                                                <span class="text-green-600">Justifié</span>
                                            <?php else : ?>
                                                <button onclick="openModal(<?= $absence['id'] ?>)" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">Justifier</button>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-4 px-6 text-sm">
                                            <?php if (isset($absence['justification_id'])) : ?>
                                                <span class="text-green-600">En Cours de Validation</span>
                                            <?php else : ?>
                                                <button class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">En Attente</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="py-4 px-6 text-sm text-gray-500 text-center">Aucune absence trouvée</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal pour justifier une absence -->
            <div id="justificationModal" class="modal">
                <div class="modal-content">
                    <h2 class="text-xl font-semibold mb-4">Justifier l'absence</h2>
                    <form id="justificationForm" action="/etudiants/absences" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="absence_id" id="modalAbsenceId">
                        <textarea name="motif" placeholder="Motif de l'absence" class="border rounded-lg p-2 w-full mb-2 focus:outline-none focus:ring-2 focus:ring-blue-600"></textarea>
                        <input type="file" name="fichier" class="border rounded-lg p-2 w-full mb-2 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <div class="flex justify-end mt-4">
                            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all">Annuler</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all ml-2">Soumettre</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function openModal(absenceId) {
                    document.getElementById('modalAbsenceId').value = absenceId;
                    document.getElementById('justificationModal').classList.add('show');
                }

                function closeModal() {
                    document.getElementById('justificationModal').classList.remove('show');
                }
            </script>

</body>

</html>