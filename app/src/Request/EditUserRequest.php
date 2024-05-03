<?php

declare(strict_types=1);

namespace App\Request;

use App\Dto\EditUserDto;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class EditUserRequest
{
    public function apply(int $id, Request $request): EditUserDto
    {
        $userData = $this->extractUserData($request);

        if (isset($userData['birth_date'])) {
            $birthDate = DateTimeImmutable::createFromFormat('Y-m-d', $userData['birth_date']);

            if (!$birthDate instanceof DateTimeImmutable) {
                throw new BadRequestHttpException('Invalid date format. Please provide a date in the format Y-m-d');
            }
        }

        return new EditUserDto(
            $id,
            $userData['first_name'] ?? null,
            $userData['last_name'] ?? null,
            $userData['email'] ?? null,
            $birthDate ?? null,
        );
    }

    private function extractUserData(Request $request): array
    {
        $user = json_decode($request->request->get('user'), true);

        return is_array($user) ? $user : [];
    }
}
