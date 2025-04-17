<?php

namespace Src\Core\Entities;

class CustomerEntity
{
    private ?int $id;
    private string $name;
    private string $birth_date;
    private string $cpf;
    private string $rg;
    private string $phone;

    public function __construct(string $name, string $birth_date, string $cpf, string $rg, string $phone, ?int $id = null)
    {
        $this->name = $name;
        $this->birth_date = $birth_date;
        $this->cpf = $cpf;
        $this->rg = $rg;
        $this->phone = $phone;
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

    public function getBirthDate(): string
    {
        return $this->birth_date;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function getRg(): string
    {
        return $this->rg;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
