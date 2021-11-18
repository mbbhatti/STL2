<?php

namespace App\Controller\ACUD2\V1\Api;

use App\Service\Etag;
use App\Service\Localization;
use App\Service\Reader;
use App\Service\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/api/v1/question", name="getQuestions", methods="GET")
     *
     * @param Request $request
     * @param User $user
     * @param Etag $etag
     * @param Localization $localization
     * @param Reader $reader
     * @return JsonResponse|Response
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getQuestions(Request $request, User $user, Etag $etag, Localization $localization, Reader $reader)
    {
        $user->checkAuth($request);
        $lastUser = $user->getLast();
        $etag = $etag->getEtag();
        $sentEtag = $request->headers->get('If-None-Match');
        if ($sentEtag !== null && $etag == $sentEtag) {
            return new Response('', Response::HTTP_NOT_MODIFIED);
        }

        $acceptLanguage = $request->headers->get('Accept-Language');
        $supportedLocales = $localization->getSupportedLocales();
        $bestLocale = $localization->getBestLocale($acceptLanguage, $supportedLocales);
        $questions = $reader->read($lastUser['group'], $lastUser['study'], $bestLocale);

        return new JsonResponse($questions, Response::HTTP_OK, ['ETag' => $etag]);
    }
}

