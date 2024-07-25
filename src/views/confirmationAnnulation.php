<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'Annulation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100 text-gray-900 font-sans">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <i class="fas fa-check-circle text-green-500 text-8xl ml-36 mb-2"></i>
            <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600"> 
                <?= htmlspecialchars($message) ?></h1>
            <div class="flex justify-center">
                <a href="/professeurs/cours" class="text-white bg-indigo-600 hover:bg-indigo-700 font-semibold py-2 px-4 rounded transition duration-200">
                    Retour à la liste des cours
                </a>
            </div>
        </div>
    </div>
</body>

</html>
