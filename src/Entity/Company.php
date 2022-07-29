<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyArchive::class, orphanRemoval: true)]
    private Collection $companyArchives;

    public function __construct()
    {
        $this->companyArchives = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, CompanyArchive>
     */
    public function getCompanyArchives(): Collection
    {
        return $this->companyArchives;
    }

    public function addCompanyArchive(CompanyArchive $companyArchive): self
    {
        if (!$this->companyArchives->contains($companyArchive)) {
            $this->companyArchives->add($companyArchive);
            $companyArchive->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyArchive(CompanyArchive $companyArchive): self
    {
        if ($this->companyArchives->removeElement($companyArchive)) {
            if ($companyArchive->getCompany() === $this) {
                $companyArchive->setCompany(null);
            }
        }

        return $this;
    }
}
