<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiDocsController extends AbstractController
{
    /**
     * @Route("/api-docs", name="api_docs", methods="GET")
     */
    public function apiDocs()
    {
        $response = $this->render('swagger.json.twig');
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->add(['Content-Type' => 'application/json']);

        return $response;
    }

    /**
     * @Route("/{any}", methods="OPTIONS")
     */
    public function optionsWildcard()
    {
        return new Response(null);
    }
}

