<?php

namespace App\EventSubscriber\Admin;

use App\Entity\Company;
use App\Manager\Admin\CompanyManager;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CompanySubscriber implements EventSubscriberInterface
{
    private CompanyManager $companyManager;

    public function __construct(CompanyManager $companyManager)
    {
        $this->companyManager = $companyManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeCrudActionEvent::class => ['addEmptyCompanyArchive'],
        ];
    }

    public function addEmptyCompanyArchive(BeforeCrudActionEvent $event)
    {
        $entity = $event->getAdminContext()->getEntity()->getInstance();

        if (!($entity instanceof Company)) {
            return;
        }

        $companyArchive = $this->companyManager->preFillForm($entity);

        $entity->addCompanyArchive($companyArchive);
    }
}