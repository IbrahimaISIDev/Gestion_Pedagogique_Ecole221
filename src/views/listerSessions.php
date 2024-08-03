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
                                    echo "<button type='button' class='mt-1 bg-red-500 text-white px-2 py-1 rounded-full text-xs hover:bg-red-600 transition duration-300 ease-in-out' onclick='openModal(" . htmlspecialchars(json_encode(array_merge($session, ['cours_libelle' => $cours['libelle']]))) . ")'>Annuler</button>";                                }
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

        <div id="modal" class="fixed inset-0 hidden flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white rounded-lg shadow-2xl max-w-lg w-full p-6 relative">
                <button class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 transition duration-300 ease-in-out" onclick="closeModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Demande d'annulation de la session</h2>
                <p class="mb-4 text-gray-600">Voulez-vous vraiment annuler la session du cours de <span id="cours_libelle" class="font-semibold text-gray-800"></span> devant se tenir le <span id="session_date" class="font-semibold text-gray-800"></span> de <span id="session_heure_debut" class="font-semibold text-gray-800"></span> à <span id="session_heure_fin" class="font-semibold text-gray-800"></span> ?</p>
                <p class="mb-4 text-gray-600">Si oui, quel est le motif de l'annulation ?</p>
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
                document.getElementById('cours_libelle').innerText = session.cours_libelle;
                document.getElementById('session_date').innerText = session.date;
                document.getElementById('session_heure_debut').innerText = session.heure_debut;
                document.getElementById('session_heure_fin').innerText = session.heure_fin;
                document.getElementById('modal').classList.remove('hidden');
                document.getElementById('modal').classList.add('flex');
            }

            function closeModal() {
                document.getElementById('modal').classList.remove('flex');
                document.getElementById('modal').classList.add('hidden');
            }

            window.onclick = function(event) {
                if (event.target === document.getElementById('modal')) {
                    closeModal();
                }
            }
        </script>

</body>

</html>