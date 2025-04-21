<?php

namespace Tests\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Core\Entities\CustomerEntity;
use Src\Core\UseCases\CustomerSaveUseCase;
use Src\Core\UseCases\Contracts\CustomerRepositoryInterface;

class CustomerSaveUseCaseTest extends TestCase
{
     /** @var CustomerRepositoryInterface&MockObject */
    private CustomerRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(CustomerRepositoryInterface::class);
    }

    #[Test]
    #[TestDox("Cria um cliente com sucesso")]
    public function testCreateCustomerSuccessfully(): void
    {
        $data = [
            'name' => 'Rafael Miguel',
            'birth_date' => '1980-01-01',
            'cpf' => '123.456.789-00',
            'rg' => '1.234.567',
            'phone' => '(41) 99999-9999',
        ];

        $expectedCustomer = new CustomerEntity(
            $data['name'],
            $data['birth_date'],
            unmaskCpf($data['cpf']),
            unmaskRg($data['rg']),
            $data['phone']
        );

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByCpf')
            ->with(unmaskCpf($data['cpf']))
            ->willReturn(null);

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByRg')
            ->with(unmaskRg($data['rg']))
            ->willReturn(null);

        $this->repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(function (CustomerEntity $customer) use ($expectedCustomer) {
                return $customer->getName() === $expectedCustomer->getName()
                    && $customer->getCpf() === $expectedCustomer->getCpf()
                    && $customer->getRg() === $expectedCustomer->getRg();
            }))
            ->willReturn($expectedCustomer);

        $useCase = new CustomerSaveUseCase($this->repositoryMock);
        $result = $useCase->execute($data);

        $this->assertInstanceOf(CustomerEntity::class, $result);
        $this->assertEquals($expectedCustomer->getName(), $result->getName());
    }

    #[Test]
    #[TestDox("Atualiza um cliente com sucesso")]
    public function testUpdateCustomerSuccessfully(): void
    {
        $data = [
            'id' => 1,
            'name' => 'Rafael Miguel Updated',
            'birth_date' => '1980-01-01',
            'cpf' => '123.456.789-00',
            'rg' => '1.234.567',
            'phone' => '(41) 99999-9999',
        ];

        $existingCustomer = new CustomerEntity(
            'Rafael Miguel',
            '1980-01-01',
            unmaskCpf($data['cpf']),
            unmaskRg($data['rg']),
            $data['phone'],
            $data['id']
        );

        $this->repositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($data['id'])
            ->willReturn($existingCustomer);

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByCpf')
            ->with(unmaskCpf($data['cpf']))
            ->willReturn($existingCustomer);

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByRg')
            ->with(unmaskRg($data['rg']))
            ->willReturn($existingCustomer);

        $this->repositoryMock
            ->expects($this->once())
            ->method('edit')
            ->with($this->isInstanceOf(CustomerEntity::class))
            ->willReturn($existingCustomer);

        $useCase = new CustomerSaveUseCase($this->repositoryMock);
        $result = $useCase->execute($data);

        $this->assertInstanceOf(CustomerEntity::class, $result);
        $this->assertEquals($existingCustomer->getName(), $result->getName());
    }

    #[Test]
    #[TestDox("Lança exceção quando os campos obrigatórios estão ausentes")]
    public function testThrowsExceptionForMissingRequiredFields(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Todos os campos são obrigatórios.");

        $data = [
            'name' => '',
            'birth_date' => '',
            'cpf' => '',
            'rg' => '',
            'phone' => '',
        ];

        $useCase = new CustomerSaveUseCase($this->repositoryMock);
        $useCase->execute($data);
    }

    #[Test]
    #[TestDox("Lança exceção quando tenta criar cliente com CPF duplicado")]
    public function testThrowsExceptionForDuplicateCpf(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("CPF já cadastrado.");

        $data = [
            'name' => 'Rafael Miguel',
            'birth_date' => '1980-01-01',
            'cpf' => '123.456.789-00',
            'rg' => '1.234.567',
            'phone' => '(41) 99999-9999',
        ];

        $existingCustomer = new CustomerEntity(
            $data['name'],
            $data['birth_date'],
            unmaskCpf($data['cpf']),
            unmaskRg($data['rg']),
            $data['phone']
        );

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByCpf')
            ->with(unmaskCpf($data['cpf']))
            ->willReturn($existingCustomer);

        $useCase = new CustomerSaveUseCase($this->repositoryMock);
        $useCase->execute($data);
    }

    #[Test]
    #[TestDox("Lança exceção quando tenta criar cliente com RG duplicado")]
    public function testThrowsExceptionForDuplicateRg(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("RG já cadastrado.");

        $data = [
            'name' => 'Rafael Miguel',
            'birth_date' => '1980-01-01',
            'cpf' => '123.456.789-00',
            'rg' => '1.234.567',
            'phone' => '(41) 99999-9999',
        ];

        $existingCustomer = new CustomerEntity(
            $data['name'],
            $data['birth_date'],
            unmaskCpf($data['cpf']),
            unmaskRg($data['rg']),
            $data['phone']
        );

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByRg')
            ->with(unmaskCpf($data['rg']))
            ->willReturn($existingCustomer);

        $useCase = new CustomerSaveUseCase($this->repositoryMock);
        $useCase->execute($data);
    }
}
