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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= $customer->getId() ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= $customer->getName() ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= $customer->getBirthDate() ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= $customer->getCpf() ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= $customer->getRg() ?></td>
                        <td class="px-6 py-4 border-b border-gray-200 text-gray-700"><?= $customer->getPhone() ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p class="text-center text-gray-500 mt-4">Nenhum cliente encontrado.</p>
<?php endif; ?>