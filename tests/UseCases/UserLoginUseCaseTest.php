<?php

namespace Tests\UseCases;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Core\Entities\UserEntity;
use Src\Core\UseCases\UserLoginUseCase;
use Src\Core\UseCases\Contracts\UserRepositoryInterface;

class UserLoginUseCaseTest extends TestCase
{
    /** @var UserRepositoryInterface&MockObject */
    private UserRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(UserRepositoryInterface::class);
    }

    #[TestDox("Login com sucesso com credenciais válidas")]
    public function testLoginSuccessfullyWithValidCredentials(): void
    {
        $email = 'rafael@example.com';
        $password = 'validPassword123';
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $user = new UserEntity('Rafael Miguel', $email, $hashedPassword, 1);

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByEmail')
            ->with($email)
            ->willReturn($user);

        $useCase = new UserLoginUseCase($this->repositoryMock);
        $result = $useCase->execute($email, $password);

        $this->assertInstanceOf(UserEntity::class, $result);
        $this->assertEquals($user->getId(), $result->getId());
        $this->assertEquals($user->getEmail(), $result->getEmail());
    }

    #[TestDox("Lança exceção para credenciais inválidas")]
    public function testThrowsExceptionForInvalidCredentials(): void
    {
        $email = 'rafael@example.com';
        $password = 'invalidPassword123';
        $user = new UserEntity('Rafael Miguel', $email, password_hash('validPassword123', PASSWORD_DEFAULT), 1);

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByEmail')
            ->with($email)
            ->willReturn($user);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Credenciais inválidas.');

        $useCase = new UserLoginUseCase($this->repositoryMock);
        $useCase->execute($email, $password);
    }

    #[TestDox("Lança exceção quando o e-mail não existe")]
    public function testThrowsExceptionWhenEmailNotFound(): void
    {
        $email = 'rafael@example.com';
        $password = 'somePassword123';

        $this->repositoryMock
            ->expects($this->once())
            ->method('findByEmail')
            ->with($email)
            ->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Credenciais inválidas.');

        $useCase = new UserLoginUseCase($this->repositoryMock);
        $useCase->execute($email, $password);
    }
}
