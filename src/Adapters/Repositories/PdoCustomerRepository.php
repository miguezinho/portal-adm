<?php

namespace Src\Adapters\Repositories;

use PDO;
use Src\Core\Entities\CustomerEntity;
use Src\Core\Contracts\CustomerRepositoryInterface;

class PdoCustomerRepository implements CustomerRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(CustomerEntity $customer): CustomerEntity
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO customers (name, birth_date, cpf, rg, phone) 
             VALUES (:name, :birth_date, :cpf, :rg, :phone)"
        );

        $stmt->execute([
            ':name' => $customer->getName(),
            ':birth_date' => $customer->getBirthDate(),
            ':cpf' => $customer->getCpf(),
            ':rg' => $customer->getRg(),
            ':phone' => $customer->getPhone(),
        ]);

        $reflection = new \ReflectionClass($customer);
        $prop = $reflection->getProperty('id');
        $prop->setAccessible(true);
        $prop->setValue($customer, (int) $this->pdo->lastInsertId());

        return $customer;
    }

    public function edit(CustomerEntity $customer): CustomerEntity
    {
        $stmt = $this->pdo->prepare(
            "UPDATE customers 
             SET name = :name, 
                 birth_date = :birth_date, 
                 cpf = :cpf, 
                 rg = :rg, 
                 phone = :phone 
             WHERE id = :id"
        );

        $stmt->execute([
            ':id' => $customer->getId(),
            ':name' => $customer->getName(),
            ':birth_date' => $customer->getBirthDate(),
            ':cpf' => $customer->getCpf(),
            ':rg' => $customer->getRg(),
            ':phone' => $customer->getPhone(),
        ]);

        return $customer;
    }

    public function find(int $id): ?CustomerEntity
    {
        $stmt = $this->pdo->prepare("SELECT id, name, birth_date, cpf, rg, phone FROM customers WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $row) {
            return null;
        }

        return new CustomerEntity(
            $row['name'],
            $row['birth_date'],
            $row['cpf'],
            $row['rg'],
            $row['phone'],
            (int) $row['id']
        );
    }
    
    public function findByCpf(string $cpf): ?CustomerEntity
    {
        $stmt = $this->pdo->prepare("SELECT id, name, birth_date, cpf, rg, phone FROM customers WHERE cpf = :cpf");
        $stmt->execute([':cpf' => $cpf]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $row) {
            return null;
        }

        return new CustomerEntity(
            $row['name'],
            $row['birth_date'],
            $row['cpf'],
            $row['rg'],
            $row['phone'],
            (int) $row['id']
        );
    }

    public function findByRg(string $rg): ?CustomerEntity
    {
        $stmt = $this->pdo->prepare("SELECT id, name, birth_date, cpf, rg, phone FROM customers WHERE rg = :rg");
        $stmt->execute([':rg' => $rg]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $row) {
            return null;
        }

        return new CustomerEntity(
            $row['name'],
            $row['birth_date'],
            $row['cpf'],
            $row['rg'],
            $row['phone'],
            (int) $row['id']
        );
    }

    public function list(): array
    {
        $stmt = $this->pdo->query("SELECT id, name, birth_date, cpf, rg, phone FROM customers");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => new CustomerEntity(
            $row['name'],
            $row['birth_date'],
            $row['cpf'],
            $row['rg'],
            $row['phone'],
            (int) $row['id']
        ), $rows);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM customers WHERE id = :id");

        return $stmt->execute([':id' => $id]);
    }
}
