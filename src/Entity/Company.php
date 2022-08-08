<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
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

        $this->updatedAt = new \DateTime();

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

    //Virtual properties

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->companyArchives->last()->getName();
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
        return $this->companyArchives->last()->getSiren();
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
        return $this->companyArchives->last()->getRegistrationCity();
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
        return $this->companyArchives->last()->getRegistrationDate();
    }

    public function setRegistrationDate(?\DateTimeInterface $registrationDate): self
    {
        $this->companyArchives->last()->setRegistrationDate($registrationDate);

        return $this;
    }

    public function getLegalStatus(): ?LegalStatus
    {
        return $this->companyArchives->last()->getLegalStatus();
    }

    public function setLegalStatus(?LegalStatus $legalStatus): self
    {
        $this->companyArchives->last()->setLegalStatus($legalStatus);

        return $this;
    }

    public function getSites(): ArrayCollection|PersistentCollection
    {
        return $this->companyArchives->last()->getSites();
    }

    public function setSites($sites): self
    {
        /** @var Site $site */
        foreach ($sites as $site) {
            $this->companyArchives->last()->addSite($site);
        }

        return $this;
    }
}
