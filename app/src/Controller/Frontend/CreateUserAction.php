<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\SaveUserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/app/user/create',
    name: 'app.user.create',
    methods: [Request::METHOD_GET, Request::METHOD_POST],
)]
final class CreateUserAction extends AbstractController
{
    public function __construct(
        private readonly UserRepository $repository,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(SaveUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($user);
        }
        return $this->render('pages/create_user.html.twig', [
            'form' => $form,
        ]);
    }
}
