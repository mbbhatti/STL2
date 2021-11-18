<?php

namespace App\Controller\ACUD2\V1\Api;

use App\Service\User;
use App\Service\Configuration;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use UnexpectedValueException;
use UnderflowException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/v1/user", name="getUser", methods="GET")
     *
     * @param Request $request
     * @param User $user
     * @param Configuration $configuration
     * @return JsonResponse
     * @throws Exception
     */
    public function getLastUser(Request $request, User $user, Configuration $configuration)
    {
        $user->checkAuth($request);
        $lastUser = $user->getLast();
        $response = [
            'left_at' => $lastUser['left_at'],
            'features' => $lastUser['features'],
            'configuration' => $configuration->get($lastUser['group'])
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * @Route("/api/v1/user", name="registerUser", methods="POST")
     *
     * @param User $user
     * @param Configuration $configuration
     * @return JsonResponse
     * @throws NonUniqueResultException
     */
    public function registerUser(User $user, Configuration $configuration)
    {
        try {
            $auth = $user->create();
            $user = $user->get($auth);
            $response = [
                'auth' => $auth,
                'features' => $user['features'],
                'configuration' => $configuration->get($user['group'])
            ];

            return new JsonResponse($response, Response::HTTP_OK);
        } catch (UnexpectedValueException $e) {
            return new JsonResponse(['ok' => false], Response::HTTP_BAD_REQUEST);
        } catch (UnderflowException $e) {
            return new JsonResponse(['ok' => false], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/api/v1/user", name="leaveStudy", methods="DELETE")
     *
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function leaveStudy(Request $request, User $user)
    {
        $user->checkAuth($request);
        $lastUser = $user->getLast();
        $left = $user->leaveStudy($lastUser['id']);

        return new JsonResponse(['ok' => $left], Response::HTTP_OK);
    }
}

