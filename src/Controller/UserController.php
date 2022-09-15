<?php

/**
 * User controller.
 */

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use App\Service\UserService;
use App\Service\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * UserController Class.
 */
#[Route('/user')]
class UserController extends AbstractController
{
    /**
     * User service.
     */
    private UserService $userService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param UserService         $userService User service
     * @param TranslatorInterface $translator  Translator
     */
    public function __construct(UserServiceInterface $userService, TranslatorInterface $translator)
    {
        $this->userService = $userService;
        $this->translator = $translator;
    }// end __construct()

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'user_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $pagination = $this->userService->getPaginatedList(
            $request->query->getInt('page', 1),
        );

        return $this->render('user/index.html.twig', ['pagination' => $pagination]);
    }// end index()

    /**
     * Edit action.
     *
     * @param Request                     $request        HTTP request
     * @param User                        $user           User entity
     * @param UserPasswordHasherInterface $passwordHasher
     *
     * @return Response HTTP response
     */
    #[Route('/{id}/edit', name: 'user_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $passwordHasher): Response
    {
        if ($this->getUser()) {
            $form = $this->createForm(
                UserType::class,
                $user,
                [
                    'method' => 'PUT',
                    'action' => $this->generateUrl('user_edit', ['id' => $user->getId()]),
                ]
            );
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $newHashedPassword = $passwordHasher->hashPassword($user, $form->getData()->getPassword());
                $this->userService->upgradePassword($user, $newHashedPassword);

                $this->addFlash(
                    'success',
                    $this->translator->trans('edited.successfully')
                );

                return $this->redirectToRoute('user_index');
            }

            return $this->render(
                'user/edit.html.twig',
                [
                    'form' => $form->createView(),
                    'user' => $user,
                ]
            );
        }

        $this->addFlash(
            'warning',
            $this->translator->trans('you.are.not.able.to.reach')
        );

        return $this->redirectToRoute('user_index');
    }// end edit()
}// end class
