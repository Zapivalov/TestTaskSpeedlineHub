<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Handler\RemoveUserHandler;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route(
    '/api/user/{id}',
    name: 'api.user.remove',
    methods: [Request::METHOD_DELETE],
)]
final class RemoveUserAction extends AbstractController
{
    public function __construct(
        private readonly RemoveUserHandler $handler,
    ) {
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            $this->handler->handle($id);

        } catch (Throwable $e) {

            return new JsonResponse(
                sprintf('Error get user: %s', $e->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(status: Response::HTTP_OK);
    }
}
