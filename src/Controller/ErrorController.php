<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ErrorController extends AbstractController
{
    public function show(Request $request, \Throwable $exception, LoggerInterface $logger, SessionInterface $session): Response
    {
        if ($exception instanceof NotFoundHttpException) {
            return $this->render('exception/error404.html.twig');
        }

        return $this->render('exception/error_common.html.twig', ['errorMessage' => $exception->getMessage()]);
    }
}
