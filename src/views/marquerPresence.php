<!-- views/marquerPresence.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marquer Présence</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Marquer Présence pour le Cours <?= htmlspecialchars($coursId) ?></h1>
        <form action="/etudiants/marquer_presence/<?= htmlspecialchars($coursId) ?>" method="post">
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 ease-in-out">Marquer Présence</button>
        </form>
    </div>
</body>
</html>
