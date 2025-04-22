<?php

namespace Tests\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Core\Entities\CustomerEntity;
use Src\Core\UseCases\Customer\CustomerFindUseCase;
use Src\Core\Contracts\CustomerRepositoryInterface;

class CustomerFindUseCaseTest extends TestCase
{
    /** @var CustomerRepositoryInterface&MockObject */
    private CustomerRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(CustomerRepositoryInterface::class);
    }

    #[TestDox("Busca um cliente pelo ID com sucesso")]
    public function testFindCustomerByIdSuccessfully(): void
    {
        $customer = new CustomerEntity('Rafael Miguel', '1980-01-01', '12345678900', '1234567', '(41) 99999-9999', 1);

        $this->repositoryMock
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($customer);

        $useCase = new CustomerFindUseCase($this->repositoryMock, 'id');
        $result = $useCase->execute(1);

        $this->assertInstanceOf(CustomerEntity::class, $result);
        $this->assertEquals($customer->getId(), $result->getId());
    }

    #[TestDox("Busca um cliente pelo CPF com sucesso")]
    public function testFindCustomerByCpfSuccessfully(): void
    {
        $cpf = '12345678900';
        $customer = new CustomerEntity('Rebecca Olivian', '1990-02-02', $cpf, '7654321', '(41) 98888-8888');

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByCpf')
            ->with($cpf)
            ->willReturn($customer);

        $useCase = new CustomerFindUseCase($this->repositoryMock, 'cpf');
        $result = $useCase->execute($cpf);

        $this->assertInstanceOf(CustomerEntity::class, $result);
        $this->assertEquals($cpf, $result->getCpf());
    }

    #[TestDox("Busca um cliente pelo RG com sucesso")]
    public function testFindCustomerByRgSuccessfully(): void
    {
        $rg = '1234567';
        $customer = new CustomerEntity('Jack Doe', '1985-03-03', '98765432100', $rg, '(41) 97777-7777');

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByRg')
            ->with($rg)
            ->willReturn($customer);

        $useCase = new CustomerFindUseCase($this->repositoryMock, 'rg');
        $result = $useCase->execute($rg);

        $this->assertInstanceOf(CustomerEntity::class, $result);
        $this->assertEquals($rg, $result->getRg());
    }

    #[TestDox("Lança exceção para tipo de busca inválido")]
    public function testThrowsExceptionForInvalidSearchType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Tipo de busca inválido 'email'. Tipos permitidos: 'id', 'cpf', 'rg'.");

        new CustomerFindUseCase($this->repositoryMock, 'email');
    }

    #[TestDox("Retorna nulo quando não encontrar nenhum registro para ID, CPF ou RG")]
    public function testReturnsNullWhenNoCustomerFound(): void
    {
        $searchValues = [
            'id' => 1,
            'cpf' => '12345678900',
            'rg' => '1234567',
        ];

        foreach ($searchValues as $searchType => $searchValue) {
            $this->repositoryMock
                ->expects($this->once())
                ->method($this->getFindMethod($searchType))
                ->with($searchValue)
                ->willReturn(null);

            $useCase = new CustomerFindUseCase($this->repositoryMock, $searchType);
            $result = $useCase->execute($searchValue);

            $this->assertNull($result);
        }
    }

    private function getFindMethod(string $searchType): string
    {
        switch ($searchType) {
            case 'id':
                return 'find';
            case 'cpf':
                return 'findByCpf';
            case 'rg':
                return 'findByRg';
            default:
                throw new \InvalidArgumentException("Tipo de busca inválido.");
        }
    }
}
