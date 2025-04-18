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

<div id="loading-spinner" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-blue-500 border-opacity-75"></div>
</div>

<script>
    $(document).on('click', '#add-address-btn', function() {
        const customerId = $(this).data('id');

        const formHtml = `
        <form id="new-address-form">
            <div class="grid grid-cols-2 gap-4">
                <input type="hidden" name="customer_id" value="${customerId}">
                <input type="text" name="zip_code" placeholder="CEP" maxlength="8" class="border rounded px-4 py-2">
                <input type="text" name="street" placeholder="Rua" readonly class="border rounded px-4 py-2 bg-gray-100 cursor-not-allowed">
                <input type="text" name="number" placeholder="Número" maxlength="10" class="border rounded px-4 py-2">
                <input type="text" name="complement" placeholder="Complemento" class="border rounded px-4 py-2">
                <input type="text" name="neighborhood" placeholder="Bairro" readonly class="border rounded px-4 py-2 bg-gray-100 cursor-not-allowed">
                <input type="text" name="city" placeholder="Cidade" readonly class="border rounded px-4 py-2 bg-gray-100 cursor-not-allowed">
                <input type="text" name="state" placeholder="Estado" readonly maxlength="2" class="border rounded px-4 py-2 bg-gray-100 cursor-not-allowed">
            </div>
            <button type="submit" class="mt-4 bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg">
                Salvar
            </button>
        </form>
    `;
        $('#addresses-content').html(formHtml);
    });

    $(document).on('change', 'input[name="zip_code"]', function() {
        const zipCode = $(this).val().replace(/\D/g, '');
        const form = $(this).closest('form');

        if (zipCode.length === 8) {
            $('#loading-spinner').removeClass('hidden');

            $.ajax({
                url: `https://viacep.com.br/ws/${zipCode}/json/`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#loading-spinner').addClass('hidden')

                    if (data.erro) {
                        alert('CEP não encontrado.');
                        return;
                    }

                    form.find('input[name="street"]').val(data.logradouro || '');
                    form.find('input[name="neighborhood"]').val(data.bairro || '');
                    form.find('input[name="city"]').val(data.localidade || '');
                    form.find('input[name="state"]').val(data.uf || '');
                },
                error: function() {
                    $('#loading-spinner').addClass('hidden')

                    alert('Erro ao buscar o endereço. Tente novamente.');
                }
            });
        }
    });


    $(document).on('submit', '#new-address-form', function(e) {
        e.preventDefault();

        const formData = $(this).serialize();
        const customerId = new URLSearchParams(formData).get('customer_id');

        $('#loading-spinner').removeClass('hidden');
        $.ajax({
            url: '/customers/address',
            method: 'POST',
            data: formData,
            success: function(response) {
                $('#loading-spinner').addClass('hidden');
                resetModal(customerId);
            },
            error: function(xhr) {
                $('#loading-spinner').addClass('hidden');

                if (xhr.responseJSON && xhr.responseJSON.error) {
                    alert(`Erro: ${xhr.responseJSON.error}`);
                } else {
                    alert('Erro ao adicionar endereço.');
                }
            }
        });

        function resetModal(customerId) {
            $('#close-modal').trigger('click');
            $('#addresses-modal').addClass('hidden');
            const button = $(`.open-addresses-modal[data-id="${customerId}"]`);
            console.log(customerId, button);
            button.trigger('click');
        }

    });

    $(document).ready(function() {
        $('.open-addresses-modal').on('click', function() {
            const customerId = $(this).data('id');
            $('#addresses-content').html('<p>Carregando...</p>');
            $('#loading-spinner').removeClass('hidden');
            $('#addresses-modal').removeClass('hidden');

            $.ajax({
                url: `/customers/addresses?id=${customerId}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    const tableHtml = renderAddressTable(data.customer.addresses);
                    const addButtonHtml = renderAddAddressButton(data.customer.id);
                    $('#addresses-content').html(tableHtml + addButtonHtml);
                    $('.modalTitle').html(`Endereços - ${data.customer.name} #${data.customer.id}`);
                    $('#loading-spinner').addClass('hidden')
                },
                error: function() {
                    $('#loading-spinner').addClass('hidden')
                    $('#close-modal').trigger('click');
                    alert("Erro ao buscar endereços!");
                }
            });
        });

        function renderAddressTable(addresses) {
            if (!addresses.length) {
                return '<p class="text-gray-500">Nenhum endereço encontrado.</p>';
            }

            let table = `
                    <div class="overflow-x-auto w-full">
                        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="text-left px-4 py-2 border-b-2 border-gray-200 text-gray-600">Rua</th>
                                    <th class="text-left px-4 py-2 border-b-2 border-gray-200 text-gray-600">Número</th>
                                    <th class="text-left px-4 py-2 border-b-2 border-gray-200 text-gray-600">Complemento</th>
                                    <th class="text-left px-4 py-2 border-b-2 border-gray-200 text-gray-600">Bairro</th>
                                    <th class="text-left px-4 py-2 border-b-2 border-gray-200 text-gray-600">Cidade</th>
                                    <th class="text-left px-4 py-2 border-b-2 border-gray-200 text-gray-600">Estado</th>
                                    <th class="text-left px-4 py-2 border-b-2 border-gray-200 text-gray-600">CEP</th>
                                </tr>
                            </thead>
                            <tbody>
    `;

            addresses.forEach(address => {
                table += `
                        <tr>
                            <td class="px-4 py-2 border-b border-gray-200">${address.street}</td>
                            <td class="px-4 py-2 border-b border-gray-200">${address.number}</td>
                            <td class="px-4 py-2 border-b border-gray-200">${address.complement}</td>
                            <td class="px-4 py-2 border-b border-gray-200">${address.neighborhood}</td>
                            <td class="px-4 py-2 border-b border-gray-200">${address.city}</td>
                            <td class="px-4 py-2 border-b border-gray-200">${address.state}</td>
                            <td class="px-4 py-2 border-b border-gray-200">${address.zip_code}</td>
                        </tr>
                    `;
            });

            table += `
                    </tbody>
                </table>
            </div>
            `;

            return table;
        }

        function renderAddAddressButton(customerId) {
            return `
            <button id="add-address-btn" data-id="${customerId}" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg">
                + Adicionar Novo Endereço
            </button>
        `;
        }

        $('#close-modal').on('click', function() {
            $('#addresses-modal').addClass('hidden');
        });

    });
</script>