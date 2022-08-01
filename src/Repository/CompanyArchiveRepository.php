<?php

namespace App\Repository;

use App\Entity\Company;
use App\Entity\CompanyArchive;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompanyArchive>
 *
 * @method CompanyArchive|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyArchive|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyArchive[]    findAll()
 * @method CompanyArchive[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyArchiveRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyArchive::class);
    }

    public function add(CompanyArchive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CompanyArchive $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLastFilled(Company $company)
    {
        return $this
            ->createQueryBuilder('ca')
            ->andWhere('ca.company = :company')
            ->andWhere('ca.name IS NOT NULL')
            ->andWhere('ca.siren IS NOT NULL')
            ->andWhere('ca.registrationCity IS NOT NULL')
            ->andWhere('ca.registrationDate IS NOT NULL')
            ->setParameter('company', $company)
            ->orderBy('ca.id', 'DESC')
            ->getQuery()
            ->setMaxResults(1)
            ->getOneOrNullResult()
        ;
    }

    public function findByCompanyAndDate(Company $company, string $date)
    {
        return $this
            ->createQueryBuilder('ca')
            ->andWhere('ca.company = :company')
            ->andWhere('ca.createdAt <= :date')
            ->setParameters([
                'company' => $company,
                'date' => $date
            ])
            ->setMaxResults(1)
            ->orderBy('ca.createdAt', 'DESC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
