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
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #343a40;
            color: #ffffff;
            height: 100vh;
            width: 250px;
            /* Ajustez la largeur du sidebar */
        }

        .sidebar a {
            color: #ffffff;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .sidebar-header {
            background-color: #007bff;
            padding: 1rem;
            font-weight: 600;
        }

        .content {
            flex: 1;
            padding: 2rem;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1rem;
        }

        .day-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 0.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            text-align: center;
        }

        .calendar-day {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 1rem;
            min-height: 100px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .event {
            background-color: #e9ecef;
            color: #495057;
            padding: 0.5rem;
            border-radius: 0.375rem;
            margin-bottom: 0.5rem;
        }

        .modal-content {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
        }

        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.4);
        }
    </style>
</head>

<body class="text-gray-900">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="sidebar bg-gradient-to-b from-blue-600 to-gray-500 text-white shadow-2xl">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-8 text-center">Menu</h2>
                <nav>
                    <ul class="space-y-4">
                        <li>
                            <a href="/etudiants/emploi_du_temps" class="flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-calendar-alt mr-3"></i> Emploi du Temps
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/cours" class="flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-book mr-3"></i> Liste des Cours
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/absences" class="flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-calendar-times mr-3"></i> Liste des Absences
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/calendrier" class="flex items-center py-3 px-4 rounded-lg">
                                <i class="fas fa-calendar-alt mr-3"></i> Calendrier des Sessions
                            </a>
                        </li>
                        <li>
                            <a href="/logout" class="flex items-center py-3 px-4 text-red-300 hover:bg-red-600 hover:text-white rounded-lg mt-8">
                                <i class="fas fa-sign-out-alt mr-3"></i> Déconnexion
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="content bg-gray-100">
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

                    $startDate = new DateTime();
                    $startDate->setISODate($currentYear, $currentWeek);
                    $daysOfWeek = [];
                    for ($i = 0; $i < 7; $i++) {
                        $daysOfWeek[] = [
                            'date' => $startDate->format('Y-m-d'),
                            'day' => $startDate->format('j'),
                            'dayName' => strftime('%A', $startDate->getTimestamp())
                        ];
                        $startDate->modify('+1 day');
                    }
                    ?>
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-semibold text-blue-600">Semaine <?= $currentWeek ?> : <?= $currentMonth ?> <?= $currentYear ?></h2>
                    </div>

                    <div class="calendar-grid">
                        <?php foreach ($daysOfWeek as $day) : ?>
                            <div class="day-header text-center">
                                <?= $day['dayName'] ?><br>
                                <?= $day['day'] ?> <?= $currentMonth ?>
                            </div>
                        <?php endforeach; ?>

                        <?php
                        $coursByDay = array_fill(0, 7, []);
                        foreach ($emploiDuTemps as $session) {
                            $dayIndex = (int)date('N', strtotime($session['date'])) - 1;
                            $coursByDay[$dayIndex][] = $session;
                        }
                        ?>

                        <?php for ($i = 0; $i < 7; $i++) : ?>
                            <div class="calendar-day">
                                <?php if (!empty($coursByDay[$i])) : ?>
                                    <?php foreach ($coursByDay[$i] as $session) : ?>
                                        <div class="event mb-4">
                                            <p class="font-semibold"><?= htmlspecialchars($session['libelle']) ?></p>
                                            <p><?= htmlspecialchars($session['heure_debut']) ?> - <?= htmlspecialchars($session['heure_fin']) ?></p>
                                            <button type="button" class="mt-2 bg-blue-600 text-white px-4 py-1 rounded-md text-sm hover:bg-blue-700 transition duration-300 ease-in-out" onclick='openModal(<?= json_encode($session) ?>)'>Présence</button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p class="text-center text-gray-500">Pas de cours</p>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <a href="/etudiants/cours" class="mt-8 inline-block text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out">
                        <i class="fas fa-arrow-left mr-2"></i> Retour aux cours
                    </a>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal -->
<div id="presenceModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 px-6 py-4">
                <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">Marquer Présence</h3>
            </div>
            <div class="px-6 py-4">
                <div class="mt-2">
                    <p class="text-sm text-gray-600" id="modal-content">
                        <!-- Contenu dynamique -->
                    </p>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-4">
                <button type="button" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:text-sm transition ease-in-out duration-150" onclick="submitPresence()">Marquer</button>
                <button type="button" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-200 text-base font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:text-sm transition ease-in-out duration-150" onclick="closeModal()">Annuler</button>
            </div>
        </div>
    </div>
</div>

<!-- Notification -->
<div id="confirmationNotification" class="fixed bottom-16 right-4 mb-4 mr-4 bg-blue-600 text-white p-4 rounded-lg shadow-lg transform scale-95 opacity-0 transition-all duration-300">
    <p id="notificationMessage" class="text-sm font-medium">Présence marquée avec succès !</p>
</div>

<script>
    function openModal(session) {
        const modal = document.getElementById('presenceModal');
        const content = document.getElementById('modal-content');
        content.textContent = `Vous êtes sur le point de marquer votre présence pour le cours : ${session.libelle} le ${session.date}.`;
        modal.classList.remove('hidden');
    }

    function closeModal() {
        const modal = document.getElementById('presenceModal');
        modal.classList.add('hidden');
    }

    function submitPresence() {
        // Fonction pour marquer la présence (à compléter avec la logique appropriée)

        // Afficher la notification de confirmation
        const notification = document.getElementById('confirmationNotification');
        notification.classList.remove('opacity-0', 'scale-95');
        notification.classList.add('opacity-100', 'scale-100');

        // Cacher la notification après 3 secondes
        setTimeout(() => {
            notification.classList.add('opacity-0', 'scale-95');
            notification.classList.remove('opacity-100', 'scale-100');
        }, 4000);

        closeModal();
    }
</script>


</body>

</html>