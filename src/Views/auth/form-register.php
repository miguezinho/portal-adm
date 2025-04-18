<?php if (isset($_GET['errorMessage'])): ?>
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <p class="text-sm font-medium"><?= htmlspecialchars($_GET['errorMessage'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>
<?php endif; ?>

<form action="/register" method="POST" class="space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
        <input type="text" name="name" id="name" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
        <input type="email" name="email" id="email" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
        <input type="password" name="password" id="password" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirme a Senha</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <button type="submit"
            class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition duration-200">
            Registrar
        </button>
    </div>

    <p class="text-center text-sm">
        Já tem uma conta? <a href="/login" class="text-blue-600 hover:underline">Entrar</a>
    </p>
</form>