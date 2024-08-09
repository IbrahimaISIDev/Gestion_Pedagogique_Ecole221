<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emploi du Temps du Professeur</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f7ff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23d4e3f3' fill-opacity='0.4'%3E%3Cpath fill-rule='evenodd' d='M11 0l5 20H6l5-20zm42 31a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM0 72h40v4H0v-4zm0-8h31v4H0v-4zm20-16h20v4H20v-4zM0 56h40v4H0v-4zm63-25a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM53 41a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-30 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-28-8a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zM56 5a5 5 0 0 0-10 0h10zm10 0a5 5 0 0 1-10 0h10zm-3 46a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm10 0a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM21 0l5 20H16l5-20zm43 64v-4h-4v4h-4v4h4v4h4v-4h4v-4h-4zM36 13h4v4h-4v-4zm4 4h4v4h-4v-4zm-4 4h4v4h-4v-4zm8-8h4v4h-4v-4z'/%3E%3C/g%3E%3C/svg%3E");
        }

        /* Ajoutez ici les autres styles CSS du modèle original */
        .sidebar {
            background-color: #343a40;
            color: #ffffff;
            height: 100vh;
            width: 250px;
            /* Ajustez la largeur du sidebar */
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(9, 1fr);
            gap: 1rem;
        }

        .time-header {
            background-color: #007bff;
            color: #ffffff;
            padding: 0.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
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
            grid-template-columns: repeat(8, 1fr);
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

        .time-header {
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

        <main class="content py-12">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-5xl font-extrabold text-indigo-800 inline-block bg-white px-8 py-4 rounded-full shadow-xl transform -rotate-3">Emploi du Temps du Professeur</h1>
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

                    <div class="grid grid-cols-8 gap-2">
                        <div class="time-header text-center bg-gradient-to-b from-blue-200 to-blue-300 rounded-t-lg p-2">
                            <span class="block text-2xl font-bold text-indigo-900">Horaire</span>
                        </div>
                        <?php foreach ($daysOfWeek as $day) : ?>
                            <div class="day-header text-center bg-gradient-to-b from-blue-200 to-blue-300 rounded-t-lg p-2">
                                <span class="block text-2xl font-bold text-indigo-900"><?= $day['dayName'] ?></span>
                                <span class="block text-sm font-semibold text-indigo-700"><?= $day['day'] ?> <?= $day['month'] ?></span>
                            </div>
                        <?php endforeach; ?>

                        <?php
                        $sessionsByDay = array_fill(0, 7, []);
                        foreach ($sessions as $session) {
                            $dayIndex = (int)date('N', strtotime($session['date'])) - 1;
                            $sessionsByDay[$dayIndex][] = $session;
                        }

                        $timeSlots = [
                            ['start' => 8, 'end' => 10],
                            ['start' => 10, 'end' => 12],
                            ['start' => 12, 'end' => 14],
                            ['start' => 14, 'end' => 16],
                            ['start' => 16, 'end' => 18]
                        ];
                        ?>

                        <?php foreach ($timeSlots as $slot) : ?>
                            <div class="time-block text-center bg-gray-50 p-2 rounded-b-lg shadow-inner">
                                <span class="block text-lg font-bold text-indigo-900"><?= $slot['start'] ?>h-<?= $slot['end'] ?>h</span>
                            </div>
                            <?php for ($i = 0; $i < 7; $i++) : ?>
                                <div class="calendar-day bg-gray-50 p-2 rounded-b-lg shadow-inner min-h-[80px] transition-all duration-300 hover:bg-gray-100">
                                    <?php if (!empty($sessionsByDay[$i])) : ?>
                                        <?php foreach ($sessionsByDay[$i] as $session) : ?>
                                            <?php
                                            $sessionStartHour = intval(substr($session['heure_debut'], 0, 2));
                                            if ($sessionStartHour >= $slot['start'] && $sessionStartHour < $slot['end']) :
                                            ?>
                                                <div class="event mb-2 bg-white p-2 rounded-lg shadow hover:shadow-md transition-all duration-300 border-l-2 border-indigo-500">
                                                    <p class="font-bold text-sm text-indigo-800"><?= htmlspecialchars($session['cours_libelle']) ?></p>
                                                    <p class="text-sm text-gray-700 mt-1">
                                                        <!-- <i class="far fa-clock mr-0 text-indigo-500"></i>
                                                        <?= htmlspecialchars($session['heure_debut']) ?> - <?= htmlspecialchars($session['heure_fin']) ?> -->
                                                    </p>
                                                    <p class="font-bold text-sm text-gray-600 mt-1">Statut: <?= htmlspecialchars($session['statut']) ?></p>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <p class="text-center text-gray-500 mt-4 text-xs italic">Pas de cours</p>
                                    <?php endif; ?>
                                </div>
                            <?php endfor; ?>
                        <?php endforeach; ?>
                    </div>

                    <a href="/professeurs/cours" class="mt-12 inline-block text-blue-600 hover:text-blue-800 transition duration-300 ease-in-out transform hover:translate-x-2 text-lg font-semibold">
                        <i class="fas fa-arrow-left mr-2"></i> Retour à mes cours
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>

</html>