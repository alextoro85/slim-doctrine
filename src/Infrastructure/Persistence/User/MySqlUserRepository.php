<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\User;

use App\Domain\User\User;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class MySqlUserRepository implements UserRepository
{
    private EntityRepository $repository;

    public function __construct(private EntityManager $entityManager)
    {
        $this->repository = $entityManager->getRepository(User::class);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function findUserOfId(int $id): User
    {
        $user = $this->repository->find($id);

        if (!$user instanceof User) {
            throw new UserNotFoundException();
        }

        return $user;
    }
}
