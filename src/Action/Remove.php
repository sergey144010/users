<?php

namespace sergey144010\users\Action;


use Twig\Environment;
use sergey144010\users\Repository\RepositoryInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;
use Zend\ServiceManager\ServiceManager;

class Remove
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

        $repository->remove($id);

        $users = $repository->getList();
        $view = $twig->render('changeList.html.twig', [
            'users' => $users
        ]);
        $response = new HtmlResponse($view);
        return $response;
    }
}