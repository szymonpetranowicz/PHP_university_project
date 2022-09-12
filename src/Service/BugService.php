<?php
/**
 * Bug service.
 */

namespace App\Service;

use App\Entity\Bug;
use App\Repository\BugRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * Class BugService.
 */
class BugService implements BugServiceInterface
{
    /**
     * Category service.
     */
    private CategoryServiceInterface $categoryService;
    /**
     * Bug repository.
     */
    private BugRepository $bugRepository;

    /**
     * Paginator.
     */
    private PaginatorInterface $paginator;

    /**
     * Constructor.
     *
     * @param CategoryServiceInterface $categoryService Category service
     * @param BugRepository            $bugRepository   Bug repository
     * @param PaginatorInterface       $paginator       Paginator
     */
    public function __construct(BugRepository $bugRepository, PaginatorInterface $paginator, CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
        $this->bugRepository = $bugRepository;
        $this->paginator = $paginator;
    }

    /**
     * Get paginated list.
     *
     * @param int                $page    Page number
     * @param array<string, int> $filters Filters array
     *
     * @return PaginationInterface<string, mixed> Paginated list
     */
    public function getPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->bugRepository->queryAll($filters),
            $page,
            BugRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }

    /**
     * Save entity.
     *
     * @param Bug $bug Bug entity
     */
    public function save(Bug $bug): void
    {
        $this->bugRepository->save($bug);
    }

    /**
     * Delete entity.
     *
     * @param Bug $bug Bug entity
     */
    public function delete(Bug $bug): void
    {
        $this->bugRepository->delete($bug);
    }

    /**
     * Prepare filters for the bugs list.
     *
     * @param array<string, int> $filters Raw filters from request
     *
     * @return array<string, object> Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (!empty($filters['category_id'])) {
            $category = $this->categoryService->findOneById($filters['category_id']);
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }

        return $resultFilters;
    }
}
