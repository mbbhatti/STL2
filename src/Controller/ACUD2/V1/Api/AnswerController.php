<?php

namespace App\Controller\ACUD2\V1\Api;

use Valdi\RulesBuilder;
use Valdi\Validator;
use App\Validator\TypeStringValidator;
use App\Service\Answer;
use App\Service\User;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AnswerController extends AbstractController
{
    /**
     * @Route("/api/v1/answer", name="getAnswers", methods="GET")
     *
     * @param Request $request
     * @param User $user
     * @param Answer $answer
     * @return JsonResponse
     * @throws Exception
     */
    public function getAnswers(Request $request, User $user, Answer $answer)
    {
        $user->checkAuth($request);
        $lastUser = $user->getLast();
        $answers = $answer->get($lastUser['id']);

        return new JsonResponse(['answers' => $answers], Response::HTTP_OK);
    }

    /**
     * @Route("/api/v1/answer", name="postAnswers", methods="POST")
     *
     * @param Request $request
     * @param User $user
     * @param Answer $answerProvider
     * @return JsonResponse
     * @throws Exception
     */
    public function postAnswers(Request $request, User $user, Answer $answerProvider)
    {
        $user->checkAuth($request);
        $lastUser = $user->getLast();
        $answers = json_decode($request->getContent(), true);
        if (!is_array($answers) || !isset($answers['answers']) || !is_array($answers['answers'])) {
            $error = 'Body with valid json and answers array required.';
            return new JsonResponse(['ok' => false, 'error' => $error], Response::HTTP_BAD_REQUEST);
        }
        $validator = new Validator();
        $validator->addValidator('typeString', new TypeStringValidator());
        $rules = RulesBuilder::create()
            ->addRule('answer_id', 'required')
            ->addRule('answer_id', 'typeString')
            ->addRule('answer' , 'required')
            ->addRule('answer', 'typeString')
            ->addRule('cycle', 'integer')
            ->addRule('day', 'integer')
            ->getRules();
        $issues = [];
        foreach ($answers['answers'] as $answer) {
            $validation = $validator->isValid($rules, $answer);
            if ($validation['valid'] !== true) {
                $answer['issues'] = $validation['errors'];
                $issues[] = $answer;
            }
        }
        if (count($issues) > 0) {
            $response = [
                'ok' => false,
                'error' => 'Answer element not valid.',
                'issues' => $issues
            ];
            return new JsonResponse($response, Response::HTTP_BAD_REQUEST);
        }
        $answerProvider->insertUserAnswers($answers['answers'], $lastUser['id'], $lastUser['study']);

        return new JsonResponse(['ok' => true], Response::HTTP_OK);
    }
}

