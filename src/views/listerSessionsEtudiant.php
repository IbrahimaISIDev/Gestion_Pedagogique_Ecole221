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
    <div class="container mx-auto p-6">
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
</body>

</html>