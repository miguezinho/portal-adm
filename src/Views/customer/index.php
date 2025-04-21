<?php if (isset($_GET['errorMessage'])): ?>
    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        <p class="text-sm font-medium"><?= htmlspecialchars($_GET['errorMessage'], ENT_QUOTES, 'UTF-8') ?></p>
    </div>
<?php endif; ?>

<div class="flex justify-between items-center mb-4">
    <a href="/customers/create" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
        + Cadastrar Cliente
    </a>
</div>
<?php if (!empty($customers)): ?>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="text-left px-6 py-3 border-b-2 border-gray-200 text-gray-600 font-semibold">ID</th>
                    <th class="text-left px-6 py-3 border-b-2 border-gray-200 text-gray-600 font-semibold">Nome</th>
                    <th class="text-left px-6 py-3 border-b-2 border-gray-200 text-gray-600 font-semibold">Data Nascimento</th>
                    <th class="text-left px-6 py-3 border-b-2 border-gray-200 text-gray-600 font-semibold">CPF</th>
                    <th class="text-left px-6 py-3 border-b-2 border-gray-200 text-gray-600 font-semibold">RG</th>
                    <th class="text-left px-6 py-3 border-b-2 border-gray-200 text-gray-600 font-semibold">Telefone</th>
                    <th class="text-left px-6 py-3 border-b-2 border-gray-200 text-gray-600 font-semibold">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= $customer->getId() ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= $customer->getName() ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= formatDateToBrazilian($customer->getBirthDate()) ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= maskCpf($customer->getCpf()) ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= maskRg($customer->getRg()) ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= $customer->getPhone() ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700">
                            <div class="flex space-x-2">
                                <a href="/customers/edit?id=<?= $customer->getId() ?>"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-semibold py-1 px-3 rounded-lg shadow-md">
                                    Editar
                                </a>
                                <button data-id="<?= $customer->getId() ?>" class="bg-green-500 hover:bg-green-600 text-white text-sm font-semibold py-1 px-3 rounded-lg shadow-md open-addresses-modal">
                                    Endereços
                                </button>
                                <form action="/customers/delete" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
                                    <input type="hidden" name="id" value="<?= $customer->getId() ?>">
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm font-semibold py-1 px-3 rounded-lg shadow-md">
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p class="text-center text-gray-500 mt-4">Nenhum cliente encontrado.</p>
<?php endif; ?>

<div id="addresses-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-3/4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold modalTitle">Endereços</h2>
            <button id="close-modal" class="text-gray-500 hover:text-gray-700">&times;</button>
        </div>
        <div id="addresses-content" class="space-y-4">
        </div>
    </div>
</div>