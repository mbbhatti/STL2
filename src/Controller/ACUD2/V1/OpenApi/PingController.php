<?php

namespace App\Controller\ACUD2\V1\OpenApi;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PingController extends AbstractController
{
    /**
     * @Route("/openapi/v1/ping", name="ping", methods="GET")
     *
     * @param Connection $db
     * @return mixed
     */
    public function checkDatabaseConnection(Connection $db)
    {
        return new JsonResponse(['ok' => $db->ping()], Response::HTTP_OK);
    }
}

