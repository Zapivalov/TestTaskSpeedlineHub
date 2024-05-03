<?php

declare(strict_types=1);

namespace App\Request;

use App\Dto\CreateUserDto;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class CreateUserRequest extends AbstractRequest
{
    public function apply(Request $request): CreateUserDto
    {
        $userData = $this->extractUserData($request);

        if (!isset($userData['email']) || !isset($userData['birth_date'])) {
            throw new BadRequestHttpException('Email and birth_date are required fields');
        }

        $birthDate = DateTimeImmutable::createFromFormat('Y-m-d', $userData['birth_date']);

        if (!$birthDate instanceof DateTimeImmutable) {
            throw new BadRequestHttpException('Invalid date format. Please provide a date in the format Y-m-d');
        }

        return new CreateUserDto(
            $userData['first_name'] ?? null,
            $userData['last_name'] ?? null,
            $userData['email'],
            $birthDate,
        );
    }
}
