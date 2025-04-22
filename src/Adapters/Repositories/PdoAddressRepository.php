<?php

namespace Src\Adapters\Repositories;

use PDO;
use Src\Core\Entities\AddressEntity;
use Src\Core\Contracts\AddressRepositoryInterface;

class PdoAddressRepository implements AddressRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(AddressEntity $address): AddressEntity
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO addresses (customer_id, street, number, complement, neighborhood, city, state, zip_code) 
             VALUES (:customer_id, :street, :number, :complement, :neighborhood, :city, :state, :zip_code)"
        );

        $stmt->execute([
            ':customer_id' => $address->getCustomerId(),
            ':street' => $address->getStreet(),
            ':number' => $address->getNumber(),
            ':complement' => $address->getComplement(),
            ':neighborhood' => $address->getNeighborhood(),
            ':city' => $address->getCity(),
            ':state' => $address->getState(),
            ':zip_code' => $address->getZipCode(),
        ]);

        $reflection = new \ReflectionClass($address);
        $prop = $reflection->getProperty('id');
        $prop->setAccessible(true);
        $prop->setValue($address, (int) $this->pdo->lastInsertId());

        return $address;
    }

    public function listByCustomerId(int $customerId): array
    {
        $stmt = $this->pdo->prepare("SELECT id, customer_id, street, number, complement, neighborhood, city, state, zip_code
                                        FROM addresses 
                                        WHERE customer_id = :customer_id
                                    ");

        $stmt->bindParam(':customer_id', $customerId, PDO::PARAM_INT);

        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => new AddressEntity(
            $row['customer_id'],
            $row['street'],
            $row['neighborhood'],
            $row['city'],
            $row['state'],
            $row['zip_code'],
            $row['number'] ?? null,
            $row['complement'] ?? null,
            (int) $row['id']
        ), $rows);
    }

    public function list(): array
    {
        $stmt = $this->pdo->prepare("SELECT id, customer_id, street, number, complement, neighborhood, city, state, zip_code FROM addresses");

        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => new AddressEntity(
            $row['customer_id'],
            $row['street'],
            $row['neighborhood'],
            $row['city'],
            $row['state'],
            $row['zip_code'],
            $row['number'] ?? null,
            $row['complement'] ?? null,
            (int) $row['id']
        ), $rows);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM addresses WHERE id = :id");

        return $stmt->execute([':id' => $id]);
    }
}
