<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Handler\EditUserHandler;
use App\Request\EditUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route(
    '/api/user/edit/{id}',
    name: 'api.user.edit',
    methods: [Request::METHOD_POST],
)]
final class EditUserAction extends AbstractController
{
    public function __construct(
        private readonly EditUserHandler $editUserHandler,
        private readonly EditUserRequest $editUserRequest,
    ) {
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        try {
            $this->editUserHandler->handle($this->editUserRequest->apply($id, $request));
        } catch (Throwable $e) {

            return new JsonResponse(
                sprintf('Error editing user: %s', $e->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(status: Response::HTTP_CREATED);
    }
}
