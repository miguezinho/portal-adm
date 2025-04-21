$(document).on('click', '#add-address-btn', function () {
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

$(document).on('change', 'input[name="zip_code"]', function () {
    const zipCode = $(this).val().replace(/\D/g, '');
    const form = $(this).closest('form');

    if (zipCode.length === 8) {
        $('#loading-spinner').removeClass('hidden');

        $.ajax({
            url: `https://viacep.com.br/ws/${zipCode}/json/`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
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
            error: function () {
                $('#loading-spinner').addClass('hidden')

                alert('Erro ao buscar o endereço. Tente novamente.');
            }
        });
    }
});


$(document).on('submit', '#new-address-form', function (e) {
    e.preventDefault();

    const formData = $(this).serialize();
    const customerId = new URLSearchParams(formData).get('customer_id');

    $('#loading-spinner').removeClass('hidden');
    $.ajax({
        url: '/customers/address',
        method: 'POST',
        data: formData,
        success: function (response) {
            $('#loading-spinner').addClass('hidden');
            resetModal(customerId);
        },
        error: function (xhr) {
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

$(document).ready(function () {
    $('.open-addresses-modal').on('click', function () {
        const customerId = $(this).data('id');
        $('#addresses-content').html('<p>Carregando...</p>');
        $('#loading-spinner').removeClass('hidden');
        $('#addresses-modal').removeClass('hidden');

        $.ajax({
            url: `/customers/addresses?id=${customerId}`,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                const tableHtml = renderAddressTable(data.customer.addresses);
                const addButtonHtml = renderAddAddressButton(data.customer.id);
                $('#addresses-content').html(tableHtml + addButtonHtml);
                $('.modalTitle').html(`Endereços - ${data.customer.name} #${data.customer.id}`);
                $('#loading-spinner').addClass('hidden')
            },
            error: function () {
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

    $('#close-modal').on('click', function () {
        $('#addresses-modal').addClass('hidden');
    });

});