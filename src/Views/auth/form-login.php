<form action="/login" method="POST" class="space-y-4">
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
        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
            Entrar
        </button>
    </div>
</form>

<div class="mt-4 text-center">
    <p class="text-sm text-gray-600">
        Não tem uma conta?
        <a href="/register" class="text-blue-600 hover:underline">Cadastre-se</a>
    </p>
</div>