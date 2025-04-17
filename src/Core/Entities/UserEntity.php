<?php

namespace Src\Core\Entities;

class UserEntity
{
    private ?int $id;
    private string $name;
    private string $email;
    private string $passwordHash;

    public function __construct(string $name, string $email, string $passwordHash, ?int $id = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }
}
