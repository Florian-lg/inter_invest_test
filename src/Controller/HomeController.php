<?php

namespace App\Controller;

use App\Form\Type\SearchCompanyType;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function indexAction(CompanyRepository $companyRepository): Response
    {
        $lastUpdatedCompanies = $companyRepository->findLastUpdatedCompanies();
        $lastCreatedCompanies = $companyRepository->findLastCreatedCompanies();
        $searchCompanyForm = $this->createForm(SearchCompanyType::class);

        if ($searchCompanyForm->isSubmitted() && $searchCompanyForm->isValid()) {

        }

        return $this->render('home.html.twig', [
            'lastUpdatedCompanies' => $lastUpdatedCompanies,
            'lastCreatedCompanies' => $lastCreatedCompanies,
            'searchCompanyForm' => $searchCompanyForm->createView()
        ]);
    }
}