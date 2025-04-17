<?php

namespace Src\Adapters\Repositories;

use PDO;
use Src\Core\Entities\UserEntity;
use Src\Core\UseCases\Contracts\UserRepositoryInterface;

class PdoUserRepository implements UserRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(UserEntity $user): UserEntity
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)"
        );

        $stmt->execute([
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPasswordHash(),
        ]);

        $reflection = new \ReflectionClass($user);
        $prop = $reflection->getProperty('id');
        $prop->setAccessible(true);
        $prop->setValue($user, (int)$this->pdo->lastInsertId());

        return $user;
    }

    public function findByEmail(string $email): ?UserEntity
    {
        $stmt = $this->pdo->prepare("SELECT id, name, email, password FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (! $row) {
            return null;
        }

        return new UserEntity(
            $row['name'],
            $row['email'],
            $row['password'],
            (int)$row['id']
        );
    }

    public function list(): array
    {
        $stmt = $this->pdo->query("SELECT id, name, email FROM users");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => new UserEntity(
            $row['name'],
            $row['email'],
            '',
            (int)$row['id']
        ), $rows);
    }
}
