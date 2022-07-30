<?php

namespace App\EventListener;

use App\Entity\Company;
use App\Entity\CompanyArchive;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class CompanyUpdateEventListener
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function preUpdate(Company $company, LifecycleEventArgs $event): void
    {
        $companyArchive = new CompanyArchive();

        $company->addCompanyArchive($companyArchive);

        $this->entityManager->flush();
    }
}