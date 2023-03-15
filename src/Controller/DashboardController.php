<?php

declare(strict_types=1);

namespace App\Controller;

use App\Filter\CompanyDataFilter;
use App\Form\CompanyFilterType;
use App\Messenger\MessageData;
use App\Messenger\MessengerInterface;
use App\Provider\CompanyDataProvider;
use App\Provider\FinanceHistoryDataProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'dashboard.')]
class DashboardController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'form' => $this->createForm(
                CompanyFilterType::class,
                new CompanyDataFilter(),
                ['action' => $this->generateUrl('dashboard.company.finance-history')]
            ),
        ]);
    }

    #[Route('/company-history', name: 'company.finance-history', methods: ['POST'])]
    public function getCompanyFinanceHistoryData(
        Request $request,
        CompanyDataProvider $companyDataProvider,
        FinanceHistoryDataProvider $financeHistoryDataProvider,
        MessengerInterface $messenger,
    ): JsonResponse {
        $form = $this->createForm(
            CompanyFilterType::class,
            new CompanyDataFilter(),
            ['action' => $this->generateUrl('dashboard.company.finance-history')]
        );
        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var CompanyDataFilter $filter */
                $filter = $form->getData();
                $companyData = $companyDataProvider->getCompany($filter);
                $message = new MessageData(
                    'Company Symbol = '.$companyData['Symbol'].' => Company Name = '.$companyData['Company Name'],
                    $filter->getEmail(),
                    ['startDate' => $filter->getStartDate(), 'endDate' => $filter->getEndDate()],
                    'email/email.html.twig'
                );
                $messenger->send($message);

                return new JsonResponse([
                    'form' => $this->renderView('company-filter/filter.html.twig', ['form' => $form]),
                    'company' => $companyData,
                    'financeHistory' => $financeHistoryDataProvider->getCompanyFinancialHistory($filter),
                ]);
            }
        } catch (\Exception $e) {
            $form->addError(new FormError($e->getMessage()));
        }

        return new JsonResponse([
            'form' => $this->renderView('company-filter/filter.html.twig', ['form' => $form]),
            'company' => [],
            'financeHistory' => [],
        ]);
    }
}
