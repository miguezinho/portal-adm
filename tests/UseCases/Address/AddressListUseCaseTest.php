<?php

namespace Tests\UseCases\Address;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Core\UseCases\Address\AddressListUseCase;
use Src\Core\Contracts\AddressRepositoryInterface;

class AddressListUseCaseTest extends TestCase
{
    /** @var AddressRepositoryInterface&MockObject */
    private AddressRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(AddressRepositoryInterface::class);
    }

    #[TestDox("Retorna a lista de todos os endereços")]
    public function testListAllAddresses(): void
    {
        $addresses = [
            ['id' => 1, 'street' => 'Rua A', 'customer_id' => 1],
            ['id' => 2, 'street' => 'Rua B', 'customer_id' => 2],
        ];

        $this->repositoryMock
            ->expects($this->once())
            ->method('list')
            ->willReturn($addresses);

        $useCase = new AddressListUseCase($this->repositoryMock);
        $result = $useCase->execute();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals($addresses, $result);
    }

    #[TestDox("Retorna a lista de endereços de um cliente específico")]
    public function testListAddressesByCustomerId(): void
    {
        $customerId = 1;
        $addresses = [
            ['id' => 1, 'street' => 'Rua A', 'customer_id' => $customerId],
        ];

        $this->repositoryMock
            ->expects($this->once())
            ->method('listByCustomerId')
            ->with($customerId)
            ->willReturn($addresses);

        $useCase = new AddressListUseCase($this->repositoryMock);
        $result = $useCase->execute($customerId);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertEquals($addresses, $result);
    }

    #[TestDox("Retorna uma lista vazia se não houver endereços")]
    public function testListReturnsEmptyArrayWhenNoAddresses(): void
    {
        $this->repositoryMock
            ->expects($this->once())
            ->method('list')
            ->willReturn([]);

        $useCase = new AddressListUseCase($this->repositoryMock);
        $result = $useCase->execute();

        $this->assertIsArray($result);
        $this->assertCount(0, $result);
    }
}
