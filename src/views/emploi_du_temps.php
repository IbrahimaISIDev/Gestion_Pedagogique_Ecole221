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
            background-color: #f0f7ff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23d4e3f3' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M11 0l5 20H6l5-20zm42 31a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM0 72h40v4H0v-4zm0-8h31v4H0v-4zm20-16h20v4H20v-4zM0 56h40v4H0v-4zm63-25a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM53 41a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-30 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-28-8a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zM56 5a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zm-3 46a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM21 0l5 20H16l5-20zm43 64v-4h-4v4h-4v4h4v4h4v-4h4v-4h-4zM36 13h4v4h-4v-4zm4 4h4v4h-4v-4zm-4 4h4v4h-4v-4zm8-8h4v4h-4v-4z'/%3E%3C/g%3E%3C/svg%3E");
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
        <main class="content py-12">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-5xl font-extrabold text-indigo-800 inline-block bg-white px-8 py-4 rounded-full shadow-xl transform -rotate-3">Emploi du Temps</h1>
                </div>

                <div class="bg-white shadow-2xl rounded-3xl p-8 mb-8 transition-all duration-300 hover:shadow-3xl">
                    <?php
                    $currentWeek = date('W');
                    $currentYear = date('Y');
                    setlocale(LC_TIME, 'fr_FR.UTF-8');

                    $startDate = new DateTime();
                    $startDate->setISODate($currentYear, $currentWeek);
                    $daysOfWeek = [];
                    for ($i = 0; $i < 7; $i++) {
                        $daysOfWeek[] = [
                            'date' => $startDate->format('Y-m-d'),
                            'day' => $startDate->format('j'),
                            'dayName' => ucfirst(strftime('%A', $startDate->getTimestamp())),
                            'month' => ucfirst(strftime('%B', $startDate->getTimestamp()))
                        ];
                        $startDate->modify('+1 day');
                    }
                    ?>
                    <div class="text-center mb-10">
                        <h2 class="text-3xl font-bold text-indigo-700">Semaine <?= $currentWeek ?> : <span class="text-blue-600"><?= $daysOfWeek[0]['month'] ?> - <?= $daysOfWeek[6]['month'] ?> <?= $currentYear ?></span></h2>
                    </div>

                    <div class="grid grid-cols-7 gap-4">
                        <?php foreach ($daysOfWeek as $day) : ?>
                            <div class="day-header text-center bg-gradient-to-b from-blue-200 to-blue-300 rounded-t-lg p-2">
                                <span class="block text-2xl font-bold text-indigo-900"><?= $day['dayName'] ?></span>
                                <span class="block text-sm font-semibold text-indigo-700"><?= $day['day'] ?> <?= $day['month'] ?></span>
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
                            <div class="calendar-day bg-gray-50 p-2 rounded-b-lg shadow-inner min-h-[150px] transition-all duration-300 hover:bg-gray-100">
                                <?php if (!empty($coursByDay[$i])) : ?>
                                    <?php foreach ($coursByDay[$i] as $session) : ?>
                                        <div class="event mb-2 bg-white p-2 rounded-lg shadow hover:shadow-md transition-all duration-300 border-l-2 border-indigo-500">
                                            <p class="font-bold text-sm text-indigo-800"><?= htmlspecialchars($session['libelle']) ?></p>
                                            <p class="text-sm text-gray-700 mt-1">
                                                <i class="far fa-clock mr-0 text-indigo-500"></i>
                                                <?= htmlspecialchars($session['heure_debut']) ?> - <?= htmlspecialchars($session['heure_fin']) ?>
                                            </p>
                                            <button type="button" class="mt-1 bg-indigo-600 text-white px-2 py-2 rounded-full text-xs font-semibold hover:bg-indigo-700 transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50" onclick='openModal(<?= json_encode($session) ?>)'>
                                                <i class="fas fa-check-circle mr-1"></i>Présence
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p class="text-center text-gray-500 mt-4 text-xs italic">Pas de cours</p>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <a href="/etudiants/cours" class="mt-12 inline-block text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out transform hover:translate-x-2 text-lg font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i> Retour à la liste des cours
                    </a>
                </div>
            </div>
        </main>

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
                            <!-- Hidden input to store session ID -->
                            <input type="hidden" id="modal-session-id">
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
                const sessionIdInput = document.getElementById('modal-session-id');

                content.textContent = `Vous êtes sur le point de marquer votre présence pour le cours : ${session.libelle} le ${session.date}.`;
                sessionIdInput.value = session.id; // Store session ID in the hidden input

                modal.classList.remove('hidden');
            }

            function closeModal() {
                const modal = document.getElementById('presenceModal');
                modal.classList.add('hidden');
            }

            function submitPresence() {
                const sessionId = document.getElementById('modal-session-id').value;

                fetch(`/etudiants/marquer_presence/${sessionId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            coursId: sessionId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau ou serveur');
                        }
                        return response.json();
                    })
                    .then(data => {
                        showNotification(data.message || 'Présence marquée avec succès !');
                        closeModal();
                    })
                    .catch(error => {
                        console.error('Error marking presence:', error);
                        showNotification('Erreur lors du marquage de la présence. Veuillez réessayer.', true);
                    });
            }

            function showNotification(message, isError = false) {
                const notification = document.getElementById('confirmationNotification');
                const notificationMessage = document.getElementById('notificationMessage');

                notificationMessage.textContent = message;
                notification.classList.remove('opacity-0', 'scale-95', 'bg-blue-600', 'bg-red-600');
                notification.classList.add('opacity-100', 'scale-100', isError ? 'bg-red-600' : 'bg-blue-600');

                setTimeout(() => {
                    notification.classList.add('opacity-0', 'scale-95');
                    notification.classList.remove('opacity-100', 'scale-100');
                }, 4000);
            }
        </script>
</body>

</html>