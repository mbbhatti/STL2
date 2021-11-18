<?php

namespace App\Controller\ACUD2\Admin;

use Exception;
use CRUDlex\Service;
use App\Service\NextGroup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NextGroupController extends AbstractController
{
    /**
     * @Route("/nextGroup/import", name="nextGroup-import-view", methods="GET")
     *
     * @param Service $service
     * @return Response
     */
    public function nextGroupImport(Service $service)
    {
        return $this->render('nextGroup_import_csv.twig',['crud' => $service]);
    }

    /**
     * @Route("/nextGroup/import", name="nextGroup-import-csv", methods="POST")
     *
     * @param Request $request
     * @param Service $service
     * @param NextGroup $nextGroup
     * @return Response
     */
    public function doNextGroupImport(Request $request, Service $service, NextGroup $nextGroup)
    {
        try {
            $file = $request->files->get('file');
            if ($file === null) {
                $error = 'A csv file is required in multipart form data named "file".';
                $this->addFlash('danger', $error);
                return $this->render('nextGroup_import_csv.twig', ['crud' => $service]);
            }

            $mimeType = $file->getClientMimeType();
            if (!in_array($mimeType, ['text/csv', 'text/plain'])) {
                $error = 'Uploaded file was not a text or csv file.';
                $this->addFlash('danger', $error);
                return $this->render('nextGroup_import_csv.twig', ['crud' => $service]);
            }
            $csvContent = file_get_contents($file->getRealPath());
            $result = $nextGroup->importCSV($csvContent);
            $this->addFlash('success', $result . ' rows inserted.');
        } catch (Exception $e) {
            $error = $e->getMessage();
            $this->addFlash('danger', $error);
        }

        return $this->render('nextGroup_import_csv.twig', ['crud' => $service]);
    }
}

