<?php

namespace App\Entity;

use App\Repository\CompanyArchiveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CompanyArchiveRepository::class)]
class CompanyArchive
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'companyArchives')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Company $company = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siren = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $registrationCity = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?LegalStatus $legalStatus = null;

    #[ORM\OneToMany(mappedBy: 'companyArchive', targetEntity: Site::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $sites;

    public function __construct()
    {
        $this->sites = new ArrayCollection();

        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(?string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getRegistrationCity(): ?string
    {
        return $this->registrationCity;
    }

    public function setRegistrationCity(?string $registrationCity): self
    {
        $this->registrationCity = $registrationCity;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(?\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getLegalStatus(): ?LegalStatus
    {
        return $this->legalStatus;
    }

    public function setLegalStatus(?LegalStatus $legalStatus): self
    {
        $this->legalStatus = $legalStatus;

        return $this;
    }

    /**
     * @return Collection<int, Site>
     */
    public function getSites(): Collection
    {
        return $this->sites;
    }

    public function setSites($sites): self
    {
        $this->sites = $sites;

        return $this;
    }

    public function addSite(Site $site): self
    {
        if (!$this->sites->contains($site)) {
            $this->sites->add($site);
            $site->setCompanyArchive($this);
        }

        return $this;
    }

    public function removeSite(Site $site): self
    {
        if ($this->sites->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getCompanyArchive() === $this) {
                $site->setCompanyArchive(null);
            }
        }

        return $this;
    }

    public function getHeadOffice(): ?Site
    {
        foreach ($this->getSites() as $site) {
            if ($site->isHeadOffice()) {
                return $site;
            }
        }

        return null;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
