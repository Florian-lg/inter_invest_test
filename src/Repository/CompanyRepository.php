<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanyArchive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 *
 * @method Company|null find($id, $lockMode = null, $lockVersion = null)
 * @method Company|null findOneBy(array $criteria, array $orderBy = null)
 * @method Company[]    findAll()
 * @method Company[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function add(Company $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Company $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLastUpdatedCompanies(int $maxResults = 6): ?array
    {
        return $this
            ->createQueryBuilder('c')
            ->orderBy('c.updatedAt', 'DESC')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLastCreatedCompanies(int $maxResults = 6): ?array
    {
        return $this
            ->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findCompaniesLike(?string $value)
    {
        return $this
            ->createQueryBuilder('c')
            ->join(CompanyArchive::class, 'ca', Join::WITH, 'ca.company = c.id')
            ->andWhere('ca.name LIKE :value')
            ->setParameter('value', '%' . $value . '%')
            ->getQuery()
            ->getResult()
        ;
    }
}
