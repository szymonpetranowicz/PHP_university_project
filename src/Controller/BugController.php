<?php
/**
 * Bug controller.
 */

namespace App\Controller;

use App\Entity\Bug;
use App\Entity\User;
use App\Form\Type\BugType;
use App\Security\Voter\BugVoter;
use App\Service\BugService;
use App\Service\BugServiceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class BugController.
 */
#[Route('/')]
class BugController extends AbstractController
{
    /**
     * Bug service.
     */
    private BugService $bugService;

    /**
     * Translator.
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param BugServiceInterface $bugService Bug service
     * @param TranslatorInterface $translator Translator
     */
    public function __construct(BugServiceInterface $bugService, TranslatorInterface $translator)
    {
        $this->bugService = $bugService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     */
    #[Route(name: 'bug_index', methods: 'GET')]
    public function index(Request $request): Response
    {
        $filters = $this->getFilters($request);
        $pagination = $this->bugService->getPaginatedList(
            $request->query->getInt('page', 1),
            $filters
        );

        return $this->render('bug/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Bug $bug Bug
     *
     * @return Response HTTP response
     */
    #[Route(
        '/{id}',
        name: 'bug_show',
        requirements: ['id' => '[1-9]\d*'],
        methods: 'GET'
    )]
    /**
     * Show action.
     *
     * @param Bug $bug Bug entity
     *
     * @return Response HTTP response
     */
    #[Route('/{id}', name: 'bug_show', requirements: ['id' => '[1-9]\d*'], methods: 'GET')]
    #[IsGranted('VIEW', subject: 'bug')]
    public function show(Bug $bug): Response
    {
        if ($this->getUser()) {
            return $this->render(
                'bug/show.html.twig',
                ['bug' => $bug]
            );
        }
        $this->addFlash(
            'warning',
            $this->translator->trans('you.are.not.able.to.reach')
        );

        return $this->redirectToRoute('bug_index');
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     */
    #[Route('/create', name: 'bug_create', methods: 'GET|POST')]
    public function create(Request $request): Response
    {
        /** @var User $user
         *
         */
        $user = $this->getUser();
        if ($this->getUser()) {
            $bug = new Bug();
            $form = $this->createForm(BugType::class, $bug, ['action' => $this->generateUrl('bug_create')]);
            $bug->setAuthor($user);
            $bug->setCreatedAt(new \DateTimeImmutable());
            $bug->setUpdatedAt(new \DateTimeImmutable());
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->bugService->save($bug);

                $this->addFlash(
                    'success',
                    $this->translator->trans('created.successfully')
                );

                return $this->redirectToRoute('bug_index');
            }

            return $this->render('bug/create.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        $this->addFlash(
            'warning',
            $this->translator->trans('you.are.not.able.to.reach')
        );

        return $this->redirectToRoute('bug_index');
    }

    /**
     * Edit action.
     *
     * @param Request $request HTTP request
     * @param Bug     $bug     Bug entity
     *
     * @return Response HTTP response
     */
    #[IsGranted(BugVoter::EDIT, subject: 'bug')]
    #[Route('/{id}/edit', name: 'bug_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Request $request, Bug $bug): Response
    {
        if ($this->getUser()) {
            $form = $this->createForm(BugType::class, $bug, [
                'method' => 'PUT',
                'action' => $this->generateUrl('bug_edit', ['id' => $bug->getId()]),
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->bugService->save($bug);

                $this->addFlash(
                    'success',
                    $this->translator->trans('editted.succesfully')
                );

                return $this->redirectToRoute('bug_index');
            }

            return $this->render('bug/edit.html.twig', [
                'form' => $form->createView(),
                'bug' => $bug,
            ]);
        }

        $this->addFlash(
            'warning',
            $this->translator->trans('you.are.not.able.to.reach')
        );

        return $this->redirectToRoute('bug_index');
    }

    /**
     * Delete action.
     *
     * @param Request $request HTTP request
     * @param Bug     $bug     Bug entity
     *
     * @return Response HTTP response
     */
    #[IsGranted(BugVoter::DELETE, subject: 'bug')]
    #[Route('/{id}/delete', name: 'bug_delete', requirements: ['id' => '[1-9]\d*'], methods: 'GET|DELETE')]
    public function delete(Request $request, Bug $bug): Response
    {
        if ($this->getUser()) {
            $form = $this->createForm(BugType::class, $bug, [
                'method' => 'DELETE',
                'action' => $this->generateUrl('bug_delete', ['id' => $bug->getId()]),
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->bugService->delete($bug);

                $this->addFlash(
                    'success',
                    $this->translator->trans('deleted.successfully')
                );

                return $this->redirectToRoute('bug_index');
            }

            return $this->render('bug/delete.html.twig', [
                'form' => $form->createView(),
                'bug' => $bug,
            ]);
        }

        $this->addFlash(
            'warning',
            $this->translator->trans('you.are.not.able.to.reach')
        );

        return $this->redirectToRoute('bug_index');
    }

    /**
     * Get filters from request.
     *
     * @param Request $request HTTP request
     *
     * @return array<string, int> Array of filters
     *
     * @psalm-return array{category_id:int}
     */
    private function getFilters(Request $request): array
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');

        return $filters;
    }
}
