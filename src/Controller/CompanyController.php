<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\CompanyArchive;
use App\Form\Type\OrderType;
use App\Form\Type\SearchCompanyType;
use App\Repository\CompanyArchiveRepository;
use App\Repository\CompanyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company', name: 'company_')]
class CompanyController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function indexAction(CompanyRepository $companyRepository,
                                Request $request,
                                PaginatorInterface $paginator): Response
    {
        $searchCompanyForm = $this->createForm(SearchCompanyType::class);

        $searchCompanyForm->handleRequest($request);

        if ($searchCompanyForm->isSubmitted() && $searchCompanyForm->isValid()) {
            $searchValue = $searchCompanyForm->get('companyName')->getData();
        }

        $companies = $companyRepository->findCompaniesLike($searchValue ?? null);

        $pagination = $paginator->paginate(
            $companies,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('company/index.html.twig', [
            'pagination' => $pagination,
            'searchCompanyForm' => $searchCompanyForm->createView(),
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