<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du Temps</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f4f8;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto p-6">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-blue-600">Emploi du Temps</h1>
        </div>

        <div class="bg-white shadow-lg rounded-2xl p-8 mb-8">
            <?php
            $currentWeek = date('W');
            $currentYear = date('Y');
            setlocale(LC_TIME, 'fr_FR.UTF-8');
            $currentMonth = strftime('%B');
            ?>
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold text-blue-600">Semaine <?= $currentWeek ?> : <?= $currentMonth ?> <?= $currentYear ?></h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow-lg rounded-lg border border-gray-200">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-4">Date</th>
                            <th class="py-3 px-4">Cours</th>
                            <th class="py-3 px-4">Heure de Début</th>
                            <th class="py-3 px-4">Heure de Fin</th>
                            <th class="py-3 px-4">Présence</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($emploiDuTemps)) : ?>
                            <?php foreach ($emploiDuTemps as $session) : ?>
                                <tr>
                                    <td class="py-3 px-4"><?= htmlspecialchars(date('d/m/Y', strtotime($session['date']))) ?></td>
                                    <td class="py-3 px-4"><?= isset($session['cours_libelle']) ? htmlspecialchars($session['cours_libelle']) : 'Non spécifié' ?></td>
                                    <td class="py-3 px-4"><?= isset($session['heure_debut']) ? htmlspecialchars($session['heure_debut']) : 'Non spécifié' ?></td>
                                    <td class="py-3 px-4"><?= isset($session['heure_fin']) ? htmlspecialchars($session['heure_fin']) : 'Non spécifié' ?></td>
                                    <td class="py-3 px-4">
                                        <button class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-700" onclick="openModal(<?= htmlspecialchars($session['session_id']) ?>)">Présent</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5" class="py-3 px-4 text-center text-gray-500">Aucun cours pour cette semaine.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <a href="/etudiants/cours" class="mt-8 inline-block text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out">
                <i class="fas fa-arrow-left mr-2"></i> Retour aux cours
            </a>
        </div>
    </div>

    <!-- Modal -->
    <div id="presenceModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Marquer Présence</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">Voulez-vous marquer votre présence pour ce cours?</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form action="/etudiants/marquer_presence" method="post" id="presenceForm">
                        <input type="hidden" name="session_id" id="modalSessionId">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 sm:ml-3 sm:w-auto sm:text-sm">Oui</button>
                    </form>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm" onclick="closeModal()">Non</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(sessionId) {
            document.getElementById('modalSessionId').value = sessionId;
            document.getElementById('presenceModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('presenceModal').classList.add('hidden');
        }
    </script>
</body>

</html>