<?php

namespace Tests\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Core\Entities\CustomerEntity;
use Src\Core\UseCases\Customer\CustomerListUseCase;
use Src\Core\Contracts\CustomerRepositoryInterface;

class CustomerListUseCaseTest extends TestCase
{
    /** @var CustomerRepositoryInterface&MockObject */
    private CustomerRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(CustomerRepositoryInterface::class);
    }

    #[TestDox("Retorna uma lista de clientes com sucesso")]
    public function testListCustomersSuccessfully(): void
    {
        $customers = [
            new CustomerEntity('Rafael Miguel', '1980-01-01', '12345678900', '1234567', '(41) 99999-9999'),
            new CustomerEntity('Rebecca Olivian', '1990-02-02', '98765432100', '7654321', '(41) 98888-8888'),
        ];

        $this->repositoryMock
            ->expects($this->once())
            ->method('list')
            ->willReturn($customers);

        $useCase = new CustomerListUseCase($this->repositoryMock);
        $result = $useCase->execute();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(CustomerEntity::class, $result[0]);
    }

    #[TestDox("Retorna uma lista vazia quando não há clientes cadastrados")]
    public function testListCustomersReturnsEmptyWhenNoCustomersExist(): void
    {
        $this->repositoryMock
            ->expects($this->once())
            ->method('list')
            ->willReturn([]);

        $useCase = new CustomerListUseCase($this->repositoryMock);
        $result = $useCase->execute();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}
