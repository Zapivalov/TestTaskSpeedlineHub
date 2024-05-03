<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractRequest
{
    protected function extractUserData(Request $request): array
    {
        $user = json_decode($request->request->get('user'), true);

        return is_array($user) ? $user : [];
    }
}
