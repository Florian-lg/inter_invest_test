<?php

namespace App\Controller\Admin;

use App\Admin\Field\LegalStatusField;
use App\Entity\Company;
use App\Entity\CompanyArchive;
use App\Entity\Document;
use App\Form\Admin\Type\CompanyArchiveType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function createEntity(string $entityFqcn): Company
    {
        $company = new Company();
        $companyArchive = new CompanyArchive();

        $company->addCompanyArchive($companyArchive);

        return $company;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom')->setVirtual(true),
            TextField::new('siren', 'Siren')->setVirtual(true),
            TextField::new('registrationCity', 'Ville d\'enregistrement')->setVirtual(true),
            DateField::new('registrationDate', 'Date d\'enregistrement')->setVirtual(true),
            //LegalStatusField::new('legalStatus', 'Statut juridique')
        ];
    }
}
