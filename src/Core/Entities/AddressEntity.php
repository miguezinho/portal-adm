<?php

namespace Src\Core\Entities;

class AddressEntity
{
    private ?int $id;
    private int $customer_id;
    private string $street;
    private ?string $number;
    private ?string $complement;
    private string $neighborhood;
    private string $city;
    private string $state;
    private string $zip_code;

    public function __construct(
        int $customer_id,
        string $street,
        string $neighborhood,
        string $city,
        string $state,
        string $zip_code,
        ?string $number = null,
        ?string $complement = null,
        ?int $id = null,
    ) {
        $this->id = $id;
        $this->customer_id = $customer_id;
        $this->street = $street;
        $this->number = $number;
        $this->complement = $complement;
        $this->neighborhood = $neighborhood;
        $this->city = $city;
        $this->state = $state;
        $this->zip_code = $zip_code;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerId(): int
    {
        return $this->customer_id;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function getComplement(): ?string
    {
        return $this->complement;
    }

    public function getNeighborhood(): string
    {
        return $this->neighborhood;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getZipCode(): string
    {
        return $this->zip_code;
    }
}
