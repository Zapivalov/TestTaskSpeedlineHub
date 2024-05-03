<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

#[Route(
    '/api/user/{id}',
    name: 'api.user.get',
    methods: [Request::METHOD_GET],
)]
final class GetUserAction extends AbstractController
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    public function __invoke(int $id): JsonResponse
    {
        try {
            if (!$user = $this->repository->find($id)) {
                throw new EntityNotFoundException('User not found');
            }
        } catch (Throwable $e) {

            return new JsonResponse(
                sprintf('Error get user: %s', $e->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse($user, Response::HTTP_OK);
    }
}
