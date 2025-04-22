<?php

namespace Tests\UseCases\User;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use Src\Core\UseCases\User\UserListUseCase;
use Src\Core\Contracts\UserRepositoryInterface;
use Src\Core\Entities\UserEntity;

class UserListUseCaseTest extends TestCase
{
    /** @var UserRepositoryInterface&MockObject */
    private UserRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(UserRepositoryInterface::class);
    }

    #[TestDox("Retorna lista de usuários com sucesso")]
    public function testListUsersSuccessfully(): void
    {
        $user1 = new UserEntity(1, 'Rafael Miguel', 'rafael.miguel@example.com');
        $user2 = new UserEntity(2, 'Rebecca Olivian', 'rebecca.olivian@example.com');
        $expectedUsers = [$user1, $user2];

        $this->repositoryMock
            ->expects($this->once())
            ->method('list')
            ->willReturn($expectedUsers);

        $useCase = new UserListUseCase($this->repositoryMock);
        $result = $useCase->execute();

        $this->assertCount(2, $result);
        $this->assertInstanceOf(UserEntity::class, $result[0]);
        $this->assertEquals($user1->getId(), $result[0]->getId());
        $this->assertEquals($user2->getId(), $result[1]->getId());
    }

    #[TestDox("Retorna um array vazio quando não houver usuários")]
    public function testReturnsEmptyArrayWhenNoUsersFound(): void
    {
        $this->repositoryMock
            ->expects($this->once())
            ->method('list')
            ->willReturn([]);

        $useCase = new UserListUseCase($this->repositoryMock);
        $result = $useCase->execute();

        $this->assertEmpty($result);
    }
}
