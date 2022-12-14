<?php

namespace App\Controller\Admin;

use App\Entity\LegalStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LegalStatusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LegalStatus::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
        ];
    }
}
