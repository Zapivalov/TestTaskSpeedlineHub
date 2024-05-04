<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Form\RemoveUserType;
use App\Handler\RemoveUserHandler;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/app/user/remove/{id}',
    name: 'app.user.remove',
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
final class RemoveUserAction extends AbstractController
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly RemoveUserHandler $handler,
    ) {
    }

    public function __invoke(int $id, Request $request): Response
    {
        if (!$user = $this->repository->find($id)) {
            return $this->render('error.html.twig', [
                'error' => 'User not found',
            ]);
        }
        $form = $this->createForm(RemoveUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->handler->handle($user->getId());
        }
        return $this->render('pages/remove_user.html.twig', [
            'form' => $form,
        ]);
    }
}
