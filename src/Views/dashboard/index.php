<main class="flex-grow p-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
            <div class="bg-blue-100 text-blue-500 p-4 rounded-full">
                <i class="fa-solid fa-user-secret fa-4x"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Guardiões</p>
                <p class="text-xl font-semibold" id="users-count"><?= $usersCount ?? '0' ?></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
            <div class="bg-green-100 text-green-500 p-4 rounded-full">
                <i class="fa-solid fa-users-between-lines fa-4x"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Clientes</p>
                <p class="text-xl font-semibold" id="customers-count"><?= $customersCount ?? '0' ?></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md flex items-center space-x-4">
            <div class="bg-yellow-100 text-yellow-500 p-4 rounded-full">
                <i class="fa-solid fa-map-location-dot fa-4x"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Endereços</p>
                <p class="text-xl font-semibold" id="addresses-count"><?= $addressesCount ?? '0' ?></p>
            </div>
        </div>
    </div>
</main>