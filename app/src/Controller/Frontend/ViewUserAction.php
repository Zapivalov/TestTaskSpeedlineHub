<?php

declare(strict_types=1);

namespace App\Controller\Frontend;

use App\Entity\User;
use App\Form\SaveUserType;
use App\Form\ViewUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    '/app/user/view/{id}',
    name: 'app.user.view',
    methods: [Request::METHOD_GET],
)]
final class ViewUserAction extends AbstractController
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

        $form = $this->createForm(ViewUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->repository->save($user);
        }
        return $this->render('pages/view_user.html.twig', [
            'form' => $form,
        ]);
    }
}
