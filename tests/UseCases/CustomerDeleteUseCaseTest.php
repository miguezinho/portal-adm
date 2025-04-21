<?php

namespace Tests\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Core\UseCases\CustomerDeleteUseCase;
use Src\Core\UseCases\Contracts\CustomerRepositoryInterface;

class CustomerDeleteUseCaseTest extends TestCase
{
    /** @var CustomerRepositoryInterface&MockObject */
    private CustomerRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(CustomerRepositoryInterface::class);
    }

    #[TestDox("Deleta o cliente com sucesso")]
    public function testDeleteCustomerSuccessfully(): void
    {
        $customerId = 1;

        $this->repositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($customerId)
            ->willReturn(true);

        $useCase = new CustomerDeleteUseCase($this->repositoryMock);
        $result = $useCase->execute($customerId);

        $this->assertTrue($result);
    }

    #[TestDox("Falha ao tentar deletar um cliente inexistente")]
    public function testDeleteCustomerFailsForNonexistentCustomer(): void
    {
        $customerId = 999;

        $this->repositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($customerId)
            ->willReturn(false);

        $useCase = new CustomerDeleteUseCase($this->repositoryMock);
        $result = $useCase->execute($customerId);

        $this->assertFalse($result);
    }
}
