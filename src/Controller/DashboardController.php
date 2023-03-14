<?php

namespace App\Controller;

use App\Filter\CompanyDataFilterRapid;
use App\Form\CompanyFilterType;
use App\Provider\CompanyDataProvider;
use App\Provider\FinanceHistoryDataProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'dashboard.')]
final class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig' , [
            'form' => $this->createForm(
                CompanyFilterType::class,
                new CompanyDataFilterRapid(),
                ['action' => $this->generateUrl('dashboard.company.finance-history')]
            ),
        ]);
    }

    #[Route('/company-history', name: 'company.finance-history', methods: ['POST'])]
    public function getCompanyFinanceHistoryData(
        Request $request,
        CompanyDataProvider $companyDataProvider,
        FinanceHistoryDataProvider $financeHistoryDataProvider,
    ): JsonResponse {
        var_dump('test');
        $form = $this->createForm(
            CompanyFilterType::class,
            new CompanyDataFilterRapid(),
            ['action' => $this->generateUrl('dashboard.company.finance-history')]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var CompanyDataFilterRapid $filter */
            $filter = $form->getData();
            return new JsonResponse([
                'form' => $this->render('company-filter/filter.html.twig', ['form' => $form]),
                'company' => $companyDataProvider->getCompany($filter),
                'financeHistory' => $financeHistoryDataProvider->getCompanyFinancialHistory($filter),
            ]);
        }

        return new JsonResponse([
            'form' => $this->render('company-filter/filter.html.twig', ['form' => $form]),
            'company' => [],
            'financeHistory' => [],
        ]);
    }
}
