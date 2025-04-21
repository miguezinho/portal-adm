<?php

namespace Tests\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use Src\Core\UseCases\AddressDeleteUseCase;
use Src\Core\UseCases\Contracts\AddressRepositoryInterface;

class AddressDeleteUseCaseTest extends TestCase
{
    /** @var AddressRepositoryInterface&\PHPUnit\Framework\MockObject\MockObject */
    private AddressRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(AddressRepositoryInterface::class);
    }

    #[TestDox("Deleta o endereço com sucesso")]
    public function testDeleteAddressSuccessfully(): void
    {
        $addressId = 1;

        $this->repositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($addressId)
            ->willReturn(true);

        $useCase = new AddressDeleteUseCase($this->repositoryMock);
        $result = $useCase->execute($addressId);

        $this->assertTrue($result);
    }

    #[TestDox("Falha ao tentar deletar um endereço inexistente")]
    public function testDeleteAddressFailsForNonexistentAddress(): void
    {
        $addressId = 999;

        $this->repositoryMock
            ->expects($this->once())
            ->method('delete')
            ->with($addressId)
            ->willReturn(false);

        $useCase = new AddressDeleteUseCase($this->repositoryMock);
        $result = $useCase->execute($addressId);

        $this->assertFalse($result);
    }
}
