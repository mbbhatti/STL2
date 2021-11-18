<?php

namespace App\Controller\ACUD2\Admin;

use App\Service\Answer;
use CRUDlex\Service;
use App\Repository\StudyRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;

class CsvController extends AbstractController
{
    /**
     * @Route("/csvExport", name="csv-export", methods="GET")
     *
     * @param Service $service
     * @param StudyRepository $study
     * @return Response
     */
    public function csvExport(Service $service, StudyRepository $study)
    {
        $studies = $study->get();

        return $this->render('csv_export.twig', [
            'studies' => $studies,
            'crud' => $service
        ]);
    }

    /**
     * @Route("/csvExport", name="do-csv-export", methods="POST")
     *
     * @param Request $request
     * @param Answer $answer
     * @param StudyRepository $studyRepository
     * @return Response|StreamedResponse
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function doCsvExport(Request $request, Answer $answer, StudyRepository $studyRepository)
    {
        $study = $request->get('study');
        if (!$studyRepository->isStudyValid($study)) {
            return new Response('Study not found.', 404);
        }

        $response = new StreamedResponse();
        $response->setCallback(function() use ($study, $answer) {
            $handle = fopen('php://output', 'w');
            $answer->writeCSV($handle, $study);
            fclose($handle);
        });

        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename=answers_' . $study . '.csv');

        return $response;
    }
}

