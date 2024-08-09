<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Sessions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f7ff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23d4e3f3' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M11 0l5 20H6l5-20zm42 31a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM0 72h40v4H0v-4zm0-8h31v4H0v-4zm20-16h20v4H20v-4zM0 56h40v4H0v-4zm63-25a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM53 41a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-30 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-28-8a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zM56 5a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zm-3 46a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM21 0l5 20H16l5-20zm43 64v-4h-4v4h-4v4h4v4h4v-4h4v-4h-4zM36 13h4v4h-4v-4zm4 4h4v4h-4v-4zm-4 4h4v4h-4v-4zm8-8h4v4h-4v-4z'/%3E%3C/g%3E%3C/svg%3E");
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
        }

        .day {
            padding: 15px;
            border: 1px solid #e2e8f0;
            text-align: center;
            position: relative;
            background-color: white;
            transition: all 0.3s ease;
        }

        .day:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-3px);
        }

        .event {
            padding: 6px;
            border-radius: 6px;
            font-size: 14px;
            margin-top: 4px;
            transition: all 0.3s ease;
        }

        .event-planned {
            background-color: #4CAF50;
            color: white;
        }

        .event-cancelled {
            background-color: #F44336;
            color: white;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 50;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 30px;
            border: 1px solid #888;
            width: 90%;
            max-width: 600px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
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

<body class="bg-gray-100 text-gray-900">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-600 to-gray-500 text-white shadow-2xl h-screen">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-8 text-center">Menu</h2>
                <nav>
                    <ul class="space-y-4">
                        <li>
                            <a href="/etudiants/emploi_du_temps" class="sidebar-link flex items-center py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">
                                <i class="fas fa-calendar-alt mr-3"></i> Emploi du Temps
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/cours" class="sidebar-link flex items-center py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">
                                <i class="fas fa-book mr-3"></i> Liste des Cours
                            </a>
                        </li>
                        <li>
                            <a href="/etudiants/absences" class="sidebar-link flex items-center py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">
                                <i class="fas fa-calendar-times mr-3"></i> Liste des Absences
                            </a>
                        </li>
                        <!-- <li>
                            <a href="/etudiants/calendrier" class="sidebar-link flex items-center py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out">
                                <i class="fas fa-calendar-alt mr-3"></i> Calendrier des Sessions
                            </a>
                        </li> -->
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
        <div class="w-full container mx-auto p-6">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-blue-600">Sessions du Cours : <span class="text-gray-800"><?= htmlspecialchars($cours['libelle'] ?? 'Cours inconnu') ?></span></h1>
                <a href="/logout" class="bg-red-500 text-white px-6 py-3 rounded-full hover:bg-red-600 transition duration-300 ease-in-out flex items-center">
                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                </a>
            </div>

            <div class="bg-white shadow-lg rounded-2xl p-8 mb-8">
                <form action="/professeurs/cours/sessions/<?= htmlspecialchars($coursId) ?>" method="get" class="flex space-x-4 items-center">
                    <input type="date" name="date_filter" value="<?= htmlspecialchars($dateFilter ?? '') ?>" class="p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out" />
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition duration-300 ease-in-out flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filtrer
                    </button>
                </form>
            </div>

            <div class="bg-white shadow-lg rounded-2xl p-8 mb-8">
                <?php
                $currentMonth = date('F');
                $currentYear = date('Y');
                ?>
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-semibold text-blue-600"><?= $currentMonth ?> <?= $currentYear ?></h2>
                </div>
                <div class="calendar grid grid-cols-7 gap-4">
                    <?php
                    $daysOfWeek = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
                    foreach ($daysOfWeek as $day) {
                        echo "<div class='day font-bold text-gray-600'>$day</div>";
                    }

                    $currentMonthNum = date('m');
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonthNum, $currentYear);
                    $firstDayOfMonth = date('N', strtotime("$currentYear-$currentMonthNum-01"));

                    for ($i = 1; $i < $firstDayOfMonth; $i++) {
                        echo "<div class='day bg-gray-100'></div>";
                    }

                    $eventsByDay = [];
                    // Initialize $sessions as an empty array if not set
                    $sessions = isset($sessions) ? $sessions : [];
                    foreach ($sessions as $session) {
                        $eventDay = date('j', strtotime($session['date']));
                        if (!isset($eventsByDay[$eventDay])) {
                            $eventsByDay[$eventDay] = [];
                        }
                        $eventsByDay[$eventDay][] = $session;
                    }

                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        echo "<div class='day'><span class='font-semibold text-gray-800'>$day</span>";
                        if (isset($eventsByDay[$day])) {
                            foreach ($eventsByDay[$day] as $session) {
                                $className = 'event event-planned'; // Use a single class for all events
                                echo "<div class='$className'>";
                                echo "<span class='block'>" . htmlspecialchars($cours['libelle'] ?? 'Cours inconnu') . "</span>";
                                echo "<span class='block font-medium'>" . htmlspecialchars($session['heure_debut']) . " - " . htmlspecialchars($session['heure_fin']) . "</span>";
                                echo "</div>";
                            }
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
                <a href="/professeurs/cours" class="mt-8 inline-block text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out">
                    <i class="fas fa-arrow-left mr-2"></i> Retour aux cours
                </a>
            </div>
        </div>
    </div>

    <!-- Modal (for future use) -->
    <div id="justificationModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Justifier l'absence</h2>
            <form id="justificationForm" action="/professeurs/cours/sessions" method="post" enctype="multipart/form-data">
                <input type="hidden" name="absence_id" id="modalAbsenceId">
                <textarea name="motif" placeholder="Motif de l'absence" class="border rounded-lg p-2 w-full mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                <input type="file" name="fichier" class="border rounded-lg p-2 w-full mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <div class="flex justify-end mt-4 space-x-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">Soumettre</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Script to handle modal display
        function openModal(absenceId) {
            document.getElementById('modalAbsenceId').value = absenceId;
            document.getElementById('justificationModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('justificationModal').classList.remove('show');
        }

        document.querySelectorAll('.close').forEach(el => el.addEventListener('click', closeModal));
    </script>
</body>

</html>