<?php

namespace App\EventSubscriber;

use App\Entity\Company;
use App\Entity\CompanyArchive;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityUpdatedEvent::class => ['addEmptyCompanyArchive'],
        ];
    }

    public function addEmptyCompanyArchive(BeforeEntityUpdatedEvent $event)
    {
        /*$entity = $event->getEntityInstance();

        if (!($entity instanceof Company)) {
            return;
        }

        $companyArchive = new CompanyArchive();

        $entity->addCompanyArchive($companyArchive);*/
    }
}