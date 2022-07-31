<?php

namespace App\Form\Admin\Type;

use App\Entity\Availability;
use App\Entity\LegalStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LegalStatusType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => LegalStatus::class,
            'choice_label' => 'name',
            'choice_value' => function (?LegalStatus $entity) {
                return $entity ? $entity->getId() : '';
            },
            'label' => 'Statut juridique',
        ]);
    }

    public function getParent()
    {
        return EntityType::class;
    }
}