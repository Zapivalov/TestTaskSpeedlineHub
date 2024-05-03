<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use DateTimeImmutable;
use RuntimeException;
use Throwable;

final readonly class RemoveUserHandler
{
    public function __construct(
        private UserRepository $repository,
    ) {
    }

    public function handle(int $id): void
    {
        if (!$user = $this->repository->find($id)) {
            throw new EntityNotFoundException('User not found');
        }

        $user->isRemoved();
        $user->setUpdatedAt(new DateTimeImmutable());

        try {
            $this->repository->save($user);
        } catch (Throwable $e) {
            throw new RuntimeException('Failed to remove user');
        }
    }
}
