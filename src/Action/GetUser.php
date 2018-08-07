<?php

namespace sergey144010\users\Action;


use sergey144010\users\Repository\RepositoryInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\ServerRequest;
use Zend\ServiceManager\ServiceManager;

class GetUser
{
    /**
     * @param ServerRequest $request
     * @param ServiceManager $serviceManager
     * @return JsonResponse
     */
    public function __invoke($request, $serviceManager)
    {
        /** @var RepositoryInterface $repository */
        $repository = $serviceManager->get('repository');

        $id = $request->getAttribute('id');

        $task = $repository->get($id);

        $response = new JsonResponse([
            'id' => $task->getId(),
            'name' => $task->getName(),
            'mail' => $task->getMail(),
            'phone' => $task->getPhone(),
        ]);
        return $response;
    }
}