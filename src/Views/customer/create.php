<?php if (isset($_GET['errorMessage'])): ?>
    <p style="color:red;"><?= $_GET['errorMessage'] ?></p>
<?php endif; ?>

<form action="/customers/save" method="POST" class="grid grid-cols-2 gap-4 p-6 bg-white shadow-md rounded-lg">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
        <input type="text" name="name" id="name" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label for="birth_date" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
        <input type="date" name="birth_date" id="birth_date" required
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
        <input type="text" name="cpf" id="cpf" required maxlength="14"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label for="rg" class="block text-sm font-medium text-gray-700">RG</label>
        <input type="text" name="rg" id="rg" required maxlength="12"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div class="col-span-2">
        <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
        <input type="text" name="phone" id="phone" required maxlength="15"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div class="col-span-2 text-right">
        <button type="submit"
            class="bg-green-600 text-white py-2 px-6 rounded-md hover:bg-green-700 transition duration-200">
            Salvar Cliente
        </button>
    </div>
</form>

<script>
    function applyMask(input, maskFunction) {
        input.addEventListener('input', function() {
            input.value = maskFunction(input.value);
        });
    }

    function cpfMask(value) {
        return value
            .replace(/\D/g, '') // Remove non-numeric characters
            .replace(/(\d{3})(\d)/, '$1.$2') // Add first dot
            .replace(/(\d{3})(\d)/, '$1.$2') // Add second dot
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Add hyphen
    }

    function rgMask(value) {
        return value
            .replace(/\D/g, '') // Remove non-numeric characters
            .replace(/(\d{2})(\d)/, '$1.$2') // Add first dot
            .replace(/(\d{3})(\d)/, '$1.$2') // Add second dot
            .replace(/(\d{3})(\d{1})$/, '$1-$2'); // Add hyphen
    }

    function phoneMask(value) {
        return value
            .replace(/\D/g, '') // Remove non-numeric characters
            .replace(/(\d{2})(\d)/, '($1) $2') // Add parentheses
            .replace(/(\d{4,5})(\d{4})$/, '$1-$2'); // Add hyphen
    }

    document.addEventListener('DOMContentLoaded', function() {
        applyMask(document.getElementById('cpf'), cpfMask);
        applyMask(document.getElementById('rg'), rgMask);
        applyMask(document.getElementById('phone'), phoneMask);
    });
</script>