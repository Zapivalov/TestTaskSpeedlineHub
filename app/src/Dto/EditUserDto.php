<?php

declare(strict_types=1);

namespace App\Dto;

use DateTimeImmutable;

final readonly class EditUserDto
{
    public function __construct(
        private int $id,
        private ?string $firstName,
        private ?string $lastName,
        private ?string $email,
        private ?DateTimeImmutable $birthDate,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getBirthDate(): ?DateTimeImmutable
    {
        return $this->birthDate;
    }
}
