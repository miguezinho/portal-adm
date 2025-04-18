<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Portal Administrativo' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body class="bg-gray-100">
    <div class="flex h-screen">
        <aside class="w-1/5 bg-gray-800 text-white">
            <div class="p-4 text-lg font-bold">
                Portal Administrativo
            </div>
            <nav>
                <ul>
                    <li class="p-4 hover:bg-gray-700"><a href="/dashboard">Dashboard</a></li>
                    <li class="p-4 hover:bg-gray-700"><a href="/customers">Clientes</a></li>
                    <li class="p-4 hover:bg-gray-700"><a href="/users">Usuários</a></li>
                </ul>
            </nav>
        </aside>

        <main class="flex-1">
            <header class="bg-white shadow p-4 flex items-center justify-between">
                <h1 class="text-xl font-semibold"><?= $headerTitle ?? 'Bem-vindo!' ?></h1>
                <div class="flex items-center space-x-4">
                    <span><?= $_SESSION['user']['name'] ?></span>
                    <a href="/logout" class="text-blue-600 hover:underline">Sair</a>
                </div>
            </header>

            <div class="p-4">
                <?= $content ?>
            </div>
        </main>
    </div>

</body>

</html>