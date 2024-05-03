<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Handler\CreateUserHandler;
use App\Request\CreateUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route(
    '/api/user/create',
    name: 'api.user.create',
    methods: [Request::METHOD_POST],
)]
final class CreateUserAction extends AbstractController
{
    public function __construct(
        private readonly CreateUserHandler $createUserHandler,
        private readonly CreateUserRequest $createUserRequest,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->createUserHandler->handle($this->createUserRequest->apply($request));
        } catch (Throwable $e) {

            return new JsonResponse(
                sprintf('Error creating user: %s', $e->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(status: Response::HTTP_CREATED);
    }
}