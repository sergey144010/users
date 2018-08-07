<?php

namespace sergey144010\users\Action;


use Twig\Environment;
use sergey144010\users\Repository\RepositoryInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;
use Zend\ServiceManager\ServiceManager;

class Edit
{
    /**
     * @param ServerRequest $request
     * @param ServiceManager $serviceManager
     * @return HtmlResponse
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke($request, $serviceManager)
    {
        /** @var RepositoryInterface $repository */
        $repository = $serviceManager->get('repository');
        /** @var Environment $twig */
        $twig = $serviceManager->get('twig');

        $id = $request->getAttribute('id');
        $user = $repository->get($id);

        $view = $twig->render('newUser.html.twig',
            [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'mail' => $user->getMail(),
				'phone' => $user->getPhone()
            ]
            );
        $response = new HtmlResponse($view);
        return $response;
    }
}