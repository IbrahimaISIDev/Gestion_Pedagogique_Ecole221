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
            background-color: #f0f4f8;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
        }

        .day {
            padding: 10px;
            border: 1px solid #e2e8f0;
            text-align: center;
            position: relative;
            background-color: white;
            transition: all 0.3s ease;
        }

        .day:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .event {
            padding: 4px;
            border-radius: 4px;
            font-size: 12px;
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
            max-width: 500px;
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
    </style>
</head>

<body class="bg-gray-100 text-gray-900">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-blue-600 to-blue-800 text-white shadow-2xl rounded-r-3xl">
            <div class="p-6">
                <h2 class="text-3xl font-bold mb-8 text-center">Menu</h2>
                <nav>
                    <ul class="space-y-4">
                        <li>
                            <a href="/professeurs/cours" class="flex items-center py-3 px-4 hover:bg-blue-700 rounded-xl transition-all">
                                <i class="fas fa-book mr-3"></i> Liste des Cours
                            </a>
                        </li>
                        <li>
                            <a href="/professeurs/cours/sessions/<?= htmlspecialchars($coursId) ?>" class="flex items-center py-3 px-4 hover:bg-blue-700 rounded-xl transition-all">
                                <i class="fas fa-calendar-day mr-3"></i> Sessions
                            </a>
                        </li>
                        <li>
                            <a href="/professeurs/annulations" class="flex items-center py-3 px-4 hover:bg-blue-700 rounded-xl transition-all">
                                <i class="fas fa-exclamation-triangle mr-3"></i> Demandes d'Annulation
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
                <div class="calendar">
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
                    foreach ($sessions as $session) {
                        $eventDay = date('j', strtotime($session['date']));
                        if (!isset($eventsByDay[$eventDay])) {
                            $eventsByDay[$eventDay] = [];
                        }
                        $eventsByDay[$eventDay][] = $session;
                    }

                    for ($day = 1; $day <= $daysInMonth; $day++) {
                        echo "<div class='day'><span class='font-semibold'>$day</span>";
                        if (isset($eventsByDay[$day])) {
                            foreach ($eventsByDay[$day] as $session) {
                                $className = ($session['statut'] === 'annulée') ? 'event event-cancelled' : 'event event-planned';
                                echo "<div class='$className'>";
                                echo "<span class='block'>" . htmlspecialchars($cours['libelle'] ?? 'Cours inconnu') . "</span>";
                                echo "<span class='block font-medium'>" . htmlspecialchars($session['heure_debut']) . " - " . htmlspecialchars($session['heure_fin']) . "</span>";
                                echo "<span class='block'>" . htmlspecialchars($session['statut']) . "</span>";
                                if ($session['statut'] === 'planifiée') {
                                    echo "<button type='button' class='mt-1 bg-red-500 text-white px-2 py-1 rounded-full text-xs hover:bg-red-600 transition duration-300 ease-in-out' onclick='openModal(" . htmlspecialchars(json_encode($session)) . ")'>Annuler</button>";
                                }
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

    <!-- Modal HTML as you provided -->
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6 relative">
            <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition duration-300 ease-in-out" onclick="closeModal()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Annuler la Session</h2>
            <p class="mb-2 text-gray-600">Voulez-vous vraiment annuler la session du cours de <span id="cours_libelle" class="font-semibold text-gray-800"></span> le <span id="session_date" class="font-semibold text-gray-800"></span> de <span id="session_heure_debut" class="font-semibold text-gray-800"></span> à <span id="session_heure_fin" class="font-semibold text-gray-800"></span> ?</p>
            <p class="mb-2 text-gray-600">Quel est le motif de l'annulation ?</p>
            <form id="cancel-form" method="post" action="/professeurs/cours/sessions/annuler">
                <input type="hidden" id="session_id" name="session_id" value="">
                <textarea id="motif" name="motif" rows="4" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out mb-4" placeholder="Motif de l'annulation"></textarea>
                <div class="flex justify-end mt-4">
                    <button type="button" class="bg-gray-500 text-white px-4 py-2 rounded-lg mr-2 hover:bg-gray-600 transition duration-300 ease-in-out" onclick="closeModal()">Non</button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300 ease-in-out">Oui, Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(session) {
            document.getElementById('session_id').value = session.id;
            document.getElementById('cours_libelle').innerText = session.libelle;
            document.getElementById('session_date').innerText = session.date;
            document.getElementById('session_heure_debut').innerText = session.heure_debut;
            document.getElementById('session_heure_fin').innerText = session.heure_fin;
            document.getElementById('modal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('modal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target === document.getElementById('modal')) {
                closeModal();
            }
        }
    </script>

</body>

</html>