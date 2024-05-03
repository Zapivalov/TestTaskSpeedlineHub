<?php

declare(strict_types=1);

namespace App\Handler;

use App\Dto\EditUserDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use DateTimeImmutable;
use RuntimeException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;
use InvalidArgumentException;

final readonly class EditUserHandler
{
    public function __construct(
        private UserRepository $repository,
        private ValidatorInterface $validator,
    ) {
    }

    public function handle(EditUserDto $userDto): void
    {
        if (!$user = $this->repository->find($userDto->getId())) {
            throw new EntityNotFoundException('User not found');
        }

        if ($userDto->getFirstName() !== null) {
            $user->setFirstName($userDto->getFirstName());
        }

        if ($userDto->getLastName() !== null) {
            $user->setLastName($userDto->getLastName());
        }

        if ($userDto->getEmail() !== null) {
            $user->setEmail($userDto->getEmail());
        }

        if ($userDto->getBirthDate() !== null) {
            $user->setBirthDate($userDto->getBirthDate());
        }

        $user->setUpdatedAt(new DateTimeImmutable());

        if (count($violationList = $this->validator->validate($user)) > 0) {
            throw new InvalidArgumentException('Invalid data format ' . $violationList);
        }

        try {
            $this->repository->save($user);
        } catch (Throwable $e) {
            throw new RuntimeException('Failed to edit user');
        }
    }
}
