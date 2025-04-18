<?php if (isset($_GET['errorMessage'])): ?>
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <p class="text-sm font-medium"><?= htmlspecialchars($_GET['errorMessage'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>
<?php endif; ?>

<form action="/customers/save" method="POST" class="grid grid-cols-2 gap-4 p-6 bg-white shadow-md rounded-lg">
    <?php if (!empty($customer->getId())): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($customer->getId(), ENT_QUOTES, 'UTF-8') ?>">
    <?php endif; ?>

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
        <input type="text" name="name" id="name" required
            value="<?= htmlspecialchars($customer->getName() ?? '', ENT_QUOTES, 'UTF-8') ?>"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label for="birth_date" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
        <input type="date" name="birth_date" id="birth_date" required
            value="<?= htmlspecialchars($customer->getBirthDate() ?? '', ENT_QUOTES, 'UTF-8') ?>"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
        <input type="text" name="cpf" id="cpf" required maxlength="14"
            value="<?= maskCpf(htmlspecialchars($customer->getCpf() ?? '', ENT_QUOTES, 'UTF-8')) ?>"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div>
        <label for="rg" class="block text-sm font-medium text-gray-700">RG</label>
        <input type="text" name="rg" id="rg" required maxlength="12"
            value="<?= maskRg(htmlspecialchars($customer->getRg() ?? '', ENT_QUOTES, 'UTF-8')) ?>"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div class="col-span-2">
        <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
        <input type="text" name="phone" id="phone" required maxlength="15"
            value="<?= htmlspecialchars($customer->getPhone() ?? '', ENT_QUOTES, 'UTF-8') ?>"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
    </div>

    <div class="col-span-2 text-right">
        <button type="submit"
            class="bg-green-600 text-white py-2 px-6 rounded-md hover:bg-green-700 transition duration-200">
            Salvar
        </button>
    </div>
</form>

<script>
    function applyMask(selector, maskFunction) {
        $(selector).on('input', function() {
            const value = $(this).val();
            $(this).val(maskFunction(value));
        });
    }

    function cpfMask(value) {
        return value
            .replace(/\D/g, '')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }

    function rgMask(value) {
        return value
            .replace(/\D/g, '')
            .replace(/(\d{2})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d)/, '$1.$2')
            .replace(/(\d{3})(\d{1})$/, '$1-$2');
    }

    function phoneMask(value) {
        return value
            .replace(/\D/g, '')
            .replace(/(\d{2})(\d)/, '($1) $2')
            .replace(/(\d{4,5})(\d{4})$/, '$1-$2');
    }

    $(document).ready(function() {
        applyMask('#cpf', cpfMask);
        applyMask('#rg', rgMask);
        applyMask('#phone', phoneMask);
    });
</script>