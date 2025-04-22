<?php

namespace Tests\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Core\Entities\AddressEntity;
use Src\Core\UseCases\Address\AddressSaveUseCase;
use Src\Core\Contracts\AddressRepositoryInterface;

class AddressSaveUseCaseTest extends TestCase
{
    /** @var AddressRepositoryInterface&MockObject */
    private AddressRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(AddressRepositoryInterface::class);
    }

    #[TestDox("Salva um endereço com sucesso")]
    public function testSaveAddressSuccessfully(): void
    {
        $input = [
            'customer_id' => 1,
            'street' => 'Rua A',
            'neighborhood' => 'Bairro A',
            'city' => 'Cidade A',
            'state' => 'PR',
            'zip_code' => '12345678',
            'number' => 123,
            'complement' => 'Apartamento 101',
        ];

        $expectedAddress = new AddressEntity(
            $input['customer_id'],
            $input['street'],
            $input['neighborhood'],
            $input['city'],
            $input['state'],
            $input['zip_code'],
            $input['number'],
            $input['complement']
        );

        $this->repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(AddressEntity::class))
            ->willReturn($expectedAddress);

        $useCase = new AddressSaveUseCase($this->repositoryMock);
        $result = $useCase->execute($input);

        $this->assertInstanceOf(AddressEntity::class, $result);
        $this->assertEquals($expectedAddress->getStreet(), $result->getStreet());
    }

    #[TestDox("Lança exceção quando o ID do cliente está ausente ou inválido")]
    public function testThrowsExceptionForMissingOrInvalidCustomerId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("ID do cliente é obrigatório e deve ser numérico.");

        $input = [
            'customer_id' => null,
            'street' => 'Rua A',
            'neighborhood' => 'Bairro A',
            'city' => 'Cidade A',
            'state' => 'PR',
            'zip_code' => '12345678',
        ];

        $useCase = new AddressSaveUseCase($this->repositoryMock);
        $useCase->execute($input);
    }

    #[TestDox("Lança exceção quando o CEP está ausente ou inválido")]
    public function testThrowsExceptionForMissingOrInvalidZipCode(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("CEP é obrigatório e deve conter 8 dígitos.");

        $input = [
            'customer_id' => 1,
            'street' => 'Rua A',
            'neighborhood' => 'Bairro A',
            'city' => 'Cidade A',
            'state' => 'PR',
            'zip_code' => '12345',
        ];

        $useCase = new AddressSaveUseCase($this->repositoryMock);
        $useCase->execute($input);
    }

    #[TestDox("Lança exceção quando os campos obrigatórios estão ausentes")]
    public function testThrowsExceptionForMissingRequiredFields(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("O campo 'Rua' é obrigatório.");

        $input = [
            'customer_id' => 1,
            'street' => '',
            'neighborhood' => 'Bairro A',
            'city' => 'Cidade A',
            'state' => 'PR',
            'zip_code' => '12345678',
        ];

        $useCase = new AddressSaveUseCase($this->repositoryMock);
        $useCase->execute($input);
    }

    #[TestDox("Lança exceção quando o número não é numérico")]
    public function testThrowsExceptionForNonNumericNumber(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("O campo 'Número' deve ser numérico.");

        $input = [
            'customer_id' => 1,
            'street' => 'Rua A',
            'neighborhood' => 'Bairro A',
            'city' => 'Cidade A',
            'state' => 'PR',
            'zip_code' => '12345678',
            'number' => 'abc',
        ];

        $useCase = new AddressSaveUseCase($this->repositoryMock);
        $useCase->execute($input);
    }

    #[TestDox("Lança exceção quando o complemento excede o limite de caracteres")]
    public function testThrowsExceptionForExceedingComplementLength(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("O campo 'Complemento' não pode exceder 255 caracteres.");

        $input = [
            'customer_id' => 1,
            'street' => 'Rua A',
            'neighborhood' => 'Bairro A',
            'city' => 'Cidade A',
            'state' => 'PR',
            'zip_code' => '12345678',
            'number' => 123,
            'complement' => str_repeat('a', 256),
        ];

        $useCase = new AddressSaveUseCase($this->repositoryMock);
        $useCase->execute($input);
    }
}
