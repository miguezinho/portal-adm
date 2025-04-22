<?php

namespace Tests\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Core\Entities\UserEntity;
use Src\Core\UseCases\User\UserRegisterUseCase;
use Src\Core\UseCases\Contracts\UserRepositoryInterface;

class UserRegisterUseCaseTest extends TestCase
{
    /** @var UserRepositoryInterface&MockObject */
    private UserRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(UserRepositoryInterface::class);
    }

    #[TestDox("Lança exceção se algum campo obrigatório estiver vazio")]
    public function testThrowsExceptionIfRequiredFieldsAreEmpty(): void
    {
        $input = [
            'name' => '',
            'email' => 'user@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Todos os campos são obrigatórios.");

        $useCase = new UserRegisterUseCase($this->repositoryMock);
        $useCase->execute($input);
    }

    #[TestDox("Lança exceção se as senhas não conferirem")]
    public function testThrowsExceptionIfPasswordsDoNotMatch(): void
    {
        $input = [
            'name' => 'Rafael Miguel',
            'email' => 'rafael@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password321',
        ];

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Senhas não conferem.");

        $useCase = new UserRegisterUseCase($this->repositoryMock);
        $useCase->execute($input);
    }

    #[TestDox("Lança exceção se o e-mail já estiver cadastrado")]
    public function testThrowsExceptionIfEmailAlreadyRegistered(): void
    {
        $input = [
            'name' => 'Rafael Miguel',
            'email' => 'rafael@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByEmail')
            ->with($input['email'])
            ->willReturn(new UserEntity('Rafael Miguel', $input['email'], 'hashed_password', 1));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("E‑mail já cadastrado.");

        $useCase = new UserRegisterUseCase($this->repositoryMock);
        $useCase->execute($input);
    }

    #[TestDox("Registra um usuário com sucesso")]
    public function testRegisterUserSuccessfully(): void
    {
        $input = [
            'name' => 'Rafael Miguel',
            'email' => 'rafael@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $user = new UserEntity($input['name'], $input['email'], password_hash($input['password'], PASSWORD_BCRYPT), 1);

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByEmail')
            ->with($input['email'])
            ->willReturn(null);

        $this->repositoryMock
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(UserEntity::class))
            ->willReturn($user);

        $useCase = new UserRegisterUseCase($this->repositoryMock);
        $result = $useCase->execute($input);

        $this->assertInstanceOf(UserEntity::class, $result);
        $this->assertEquals($user->getEmail(), $result->getEmail());
    }
}
