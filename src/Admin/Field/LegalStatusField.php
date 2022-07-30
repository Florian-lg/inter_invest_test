<?php

namespace App\Admin\Field;

use App\Form\Admin\Type\LegalStatusType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;

class LegalStatusField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): LegalStatusField
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(LegalStatusType::class)
            ->setVirtual(true)
        ;
    }
}