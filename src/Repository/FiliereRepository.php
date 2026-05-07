<?php
namespace App\Repository;

use App\Entity\Filiere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class FiliereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Filiere::class);
    }

    /**
     * @return array{items: list<Filiere>, total: int}
     */
    public function findPageOrderedByNom(int $page, int $perPage = 10): array
    {
        $page = max(1, $page);
        $qb   = $this->createQueryBuilder('f')
            ->orderBy('f.nom', 'ASC')
            ->setFirstResult(($page - 1) * $perPage)
            ->setMaxResults($perPage);

        $paginator = new Paginator($qb->getQuery());

        return [
            'items' => iterator_to_array($paginator->getIterator(), false),
            'total' => count($paginator),
        ];
    }

    /**
     * Retourne les filières les plus populaires
     * (celles qui ont le plus d'établissements associés)
     *
     * @return list<Filiere>
     */
    public function findFilieresPopulaires(int $limit = 5): array
    {
        return $this->createQueryBuilder('f')
            ->leftJoin('f.etablissements', 'e')
            ->groupBy('f.id')
            ->orderBy('COUNT(e.id)', 'DESC')
            ->addOrderBy('f.nom', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}