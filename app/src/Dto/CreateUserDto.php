<?php

declare(strict_types=1);

namespace App\Dto;

use DateTimeImmutable;

final readonly class CreateUserDto
{
    public function __construct(
        private ?string $firstName,
        private ?string $lastName,
        private string $email,
        private DateTimeImmutable $birthDate,
    ) {
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->birthDate;
    }
}
