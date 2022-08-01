<?php

namespace App\Manager\Admin;

use App\Entity\Company;
use App\Entity\CompanyArchive;
use App\Entity\Site;
use App\Repository\CompanyArchiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

class CompanyManager
{
    private CompanyArchiveRepository $companyArchiveRepository;

    public function __construct(CompanyArchiveRepository $companyArchiveRepository)
    {
        $this->companyArchiveRepository = $companyArchiveRepository;
    }

    public function preFillForm(Company $company): CompanyArchive
    {
        /** @var CompanyArchive $lastCompanyArchive */
        $lastCompanyArchive = $this->companyArchiveRepository->findLastFilled($company);

        $companyArchive = new CompanyArchive();

        $companyArchive
            ->setName($lastCompanyArchive->getName())
            ->setSiren($lastCompanyArchive->getSiren())
            ->setRegistrationCity($lastCompanyArchive->getRegistrationCity())
            ->setRegistrationDate($lastCompanyArchive->getRegistrationDate())
            ->setLegalStatus($lastCompanyArchive->getLegalStatus())
        ;

        $sites = $this->handleSites($lastCompanyArchive->getSites());

        $this->adaptSites($sites, $companyArchive);

        return $companyArchive;
    }

    /**
     * Retrieve data from the sites of the current archive and adapt them to the new one by creating unlinked data
     *
     * @param ArrayCollection|PersistentCollection $previousSites
     *
     * @return array|null
     */
    private function handleSites(ArrayCollection|PersistentCollection $previousSites): ?array
    {
        $sites = [];

        /** @var Site $previousSite */
        foreach ($previousSites as $previousSite) {
            $site = new Site();

            $site
                ->setName($previousSite->getName())
                ->setCity($previousSite->getCity())
                ->setZipcode($previousSite->getZipcode())
                ->setAddress($previousSite->getAddress())
                ->setCountry($previousSite->getCountry())
                ->setIsHeadOffice($previousSite->isHeadOffice())
            ;

            $sites[] = $site;
        }

        return $sites;
    }

    /**
     * Link previously created sites to the new archive
     *
     * @param array|null $sites
     * @param CompanyArchive $companyArchive
     *
     * @return void
     */
    private function adaptSites(?array $sites, CompanyArchive $companyArchive): void
    {
        /** @var Site $site */
        foreach ($sites as $site) {
            $companyArchive->addSite($site);
        }
    }
}