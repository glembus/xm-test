<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ErrorController extends AbstractController
{
    public function show(Request $request): Response
    {
        return $this->render('exception/error404.html.twig');
    }
}
