<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Form\SaveUserType;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/app/user/edit/{id}',
    name: 'app.user.edit',
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
final class EditUserAction extends AbstractController
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    public function __invoke(int $id, Request $request): Response
    {
        if (!$user = $this->repository->find($id)) {
            return $this->render('error.html.twig', [
                'error' => 'User not found',
            ]);
        }

        $form = $this->createForm(SaveUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setUpdatedAt(new DateTimeImmutable());
            $this->repository->save($user);
        }
        return $this->render('pages/create_user.html.twig', [
            'form' => $form,
        ]);
    }
}
