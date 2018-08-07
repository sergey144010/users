<?php

namespace sergey144010\users\Action;


use sergey144010\users\User\User;
use sergey144010\users\User\Name;
use sergey144010\users\User\Mail;
use sergey144010\users\User\Phone;
use sergey144010\users\Repository\RepositoryInterface;
use Twig\Environment;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;
use Zend\ServiceManager\ServiceManager;

class Update
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

        $id = $request->getQueryParams()['id'];
        $name = $request->getQueryParams()['name'];
        $mail = $request->getQueryParams()['mail'];
        $phone = $request->getQueryParams()['phone'];

        $user = new User(new Name($name), new Mail($mail), new Phone($phone));
        $user->setId($id);
        $repository->update($user);

        $users = $repository->getList();
        $view = $twig->render('index.html.twig', [
            'users' => $users
        ]);
        $response = new HtmlResponse($view);
        return $response;
    }
}