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
    <div class="flex flex-col lg:flex-row h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white w-full lg:w-1/5 lg:block hidden" id="sidebar">
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

        <!-- Mobile Sidebar Toggle -->
        <header class="bg-gray-800 text-white p-4 lg:hidden flex justify-between items-center">
            <div class="text-lg font-bold">Portal Administrativo</div>
            <button id="toggle-sidebar" class="focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </header>

        <!-- Main Content -->
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

    <script>
        $(document).ready(function () {
            $('#toggle-sidebar').on('click', function () {
                $('#sidebar').toggleClass('hidden');
            });
        });
    </script>
</body>

</html>
