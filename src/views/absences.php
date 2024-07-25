<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Absences - Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white shadow-2xl rounded-r-3xl">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-8 text-center">Menu</h2>
                <nav>
                    <ul class="space-y-4">
                        <li>
                            <a href="/etudiants/emploi_du_temps" class="flex items-center py-3 px-4 hover:bg-blue-700 rounded-xl transition-all">
                                <i class="fas fa-calendar mr-3"></i> Emploi du Temps
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/cours" class="flex items-center py-3 px-4 hover:bg-blue-700 rounded-xl transition-all">
                                <i class="fas fa-book mr-3"></i> Liste des Cours
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/absences" class="flex items-center py-3 px-4 hover:bg-blue-700 rounded-xl transition-all">
                                <i class="fas fa-calendar-times mr-3"></i> Liste des Absences
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/calendrier" class="flex items-center py-3 px-4 hover:bg-blue-700 rounded-xl transition-all">
                                <i class="fas fa-calendar-alt mr-3"></i> Calendrier des Sessions
                            </a>
                        </li>
                        <li>
                            <a href="/logout" class="flex items-center py-3 px-4 text-red-300 hover:bg-red-600 hover:text-white rounded-xl transition-all mt-8">
                                <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden p-8 mb-8">
                <h2 class="text-3xl font-semibold mb-6 text-blue-600">Absences de l'étudiant</h2>

                <!-- Formulaire de filtrage -->
                <div class="mb-6">
                    <form action="/etudiants/absences" method="GET" class="flex space-x-4 mb-4">
                        <input type="text" name="search" placeholder="Rechercher..." value="<?= htmlspecialchars($search ?? '') ?>" class="border rounded-lg p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-600">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">Rechercher</button>
                    </form>
                </div>

                <!-- Table de données -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-4 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="py-4 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cours</th>
                                <th class="py-4 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="py-4 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                <th class="py-4 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Etat</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($absences as $absence) : ?>
                                <tr class="hover:bg-gray-50 transition-all">
                                    <td class="py-4 px-6 text-sm text-gray-700"><?= htmlspecialchars($absence['date_absence']) ?></td>
                                    <td class="py-4 px-6 text-sm text-gray-700"><?= htmlspecialchars($absence['cours_libelle']) ?></td>
                                    <td class="py-4 px-6 text-sm">
                                        <form action="/etudiants/absences" method="post" class="inline">
                                            <input type="hidden" name="absence_id" value="<?= $absence['id'] ?>">
                                            <?php if (!isset($absence['justification_id'])) : ?>
                                                <button type="submit" name="statut" value="justifie" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all">Non Justifié</button>
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
                                            <button onclick="openModal(<?= $absence['id'] ?>)" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all">En Cours de Validation</button>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal -->
    <div id="justificationModal" class="modal">
        <div class="modal-content">
            <h2 class="text-xl font-semibold mb-4">Justifier l'absence</h2>
            <form id="justificationForm" action="/etudiants/justifier_absence" method="post" enctype="multipart/form-data">
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