<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyArchive::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $companyArchives;

    public function __construct()
    {
        $this->companyArchives = new ArrayCollection();

        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
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

    /**
     * @param $companyArchives
     *
     * @return $this
     */
    public function setCompanyArchives($companyArchives): self
    {
        $this->companyArchives = $companyArchives;

        return $this;
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

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->companyArchives->count() > 0 ? $this->companyArchives->last()->getName() : null;
    }

    public function setName(?string $name): self
    {
        $this->companyArchives->last()->setName($name);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSiren(): ?string
    {
        return $this->companyArchives->count() > 0 ? $this->companyArchives->last()->getSiren() : null;
    }

    public function setSiren(?string $siren): self
    {
        $this->companyArchives->last()->setSiren($siren);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegistrationCity(): ?string
    {
        return $this->companyArchives->count() > 0 ? $this->companyArchives->last()->getRegistrationCity() : null;
    }

    public function setRegistrationCity(?string $registrationCity): self
    {
        $this->companyArchives->last()->setRegistrationCity($registrationCity);

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->companyArchives->count() > 0 ? $this->companyArchives->last()->getRegistrationDate() : null;
    }

    public function setRegistrationDate(?\DateTimeInterface $registrationDate): self
    {
        $this->companyArchives->last()->setRegistrationDate($registrationDate);

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLegalStatus(): ?string
    {
        return $this->companyArchives->count() > 0 ? $this->companyArchives->last()->getLegalStatus() : null;
    }

    public function setLegalStatus(?string $legalStatus): self
    {
        $this->companyArchives->last()->setLegalStatus($legalStatus);

        return $this;
    }
}
