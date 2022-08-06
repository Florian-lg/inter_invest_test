<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\CompanyArchive;
use App\Form\Type\ListingType;
use App\Form\Type\OrderType;
use App\Form\Type\SearchCompanyType;
use App\Repository\CompanyArchiveRepository;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company', name: 'company_')]
class CompanyController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function indexAction(CompanyRepository $companyRepository, Request $request): Response
    {
        $searchCompanyForm = $this->createForm(SearchCompanyType::class);
        $listingForm = $this->createForm(ListingType::class);

        $searchCompanyForm->handleRequest($request);
        $listingForm->handleRequest($request);

        if ($searchCompanyForm->isSubmitted() && $searchCompanyForm->isValid()) {

        }

        if ($listingForm->isSubmitted() && $listingForm->isValid()) {

        }

        return $this->render('company/index.html.twig', [
            'companies' => $companyRepository->findAll(),
            'searchCompanyForm' => $searchCompanyForm->createView(),
            'listingForm' => $listingForm->createView()
        ]);
    }

    #[Route('/{company}', name: 'show')]
    public function showAction(Company $company,
                               Request $request,
                               CompanyArchiveRepository $companyArchiveRepository): Response
    {
        if ($date = $request->get('date')) {
            /** @var CompanyArchive $companyArchive */
            if ($companyArchive = $companyArchiveRepository->findByCompanyAndDate($company, $date)) {
                return $this->render('company/show.html.twig', [
                    'company' => $companyArchive
                ]);
            }

            $this->addFlash('danger', 'Il n\'y a pas de données pour cette entreprise à la date demandée.');
        }

        return $this->render('company/show.html.twig', [
            'company' => $company->getCompanyArchives()->last()
        ]);
    }
}