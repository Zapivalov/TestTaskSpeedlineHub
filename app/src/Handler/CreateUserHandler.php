<?php

declare(strict_types=1);

namespace App\Handler;

use App\Dto\CreateUserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use RuntimeException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;
use InvalidArgumentException;

final readonly class CreateUserHandler
{
    public function __construct(
        private UserRepository $repository,
        private ValidatorInterface $validator,
    ) {
    }

    public function handle(CreateUserDto $userDto): void
    {
        $user = (new User())
            ->setFirstName($userDto->getFirstName())
            ->setLastName($userDto->getLastName())
            ->setEmail($userDto->getEmail())
            ->setBirthDate($userDto->getBirthDate())
        ;

        if (count($violationList = $this->validator->validate($user)) > 0) {
            throw new InvalidArgumentException('Invalid data format ' . $violationList);
        }

        try {
            $this->repository->save($user);
        } catch (Throwable $e) {
            throw new RuntimeException('Failed to add user');
        }
    }
}
