<?php

namespace App\Controller\Admin;

use App\Entity\LegalStatus;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LegalStatusCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LegalStatus::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
