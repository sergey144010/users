<?php

namespace sergey144010\users\Action;


use sergey144010\users\Exception\UserException;
use sergey144010\users\User\User;
use sergey144010\users\User\Name;
use sergey144010\users\User\Mail;
use sergey144010\users\User\Phone;
use sergey144010\users\Repository\RepositoryInterface;
use Twig\Environment;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\ServerRequest;
use Zend\ServiceManager\ServiceManager;

class Save
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

        $name = $request->getQueryParams()['name'];
        $mail = $request->getQueryParams()['mail'];
		$phone = $request->getQueryParams()['phone'];
        
        $user = new User(new Name($name), new Mail($mail), new Phone($phone));

        try{
            $repository->save($user);
            $view = $twig->render('success.html.twig');
        }catch(UserException $error){
            /** @var \Zend\Log\Logger $logger */
            $logger = $serviceManager->get('logger');
            $logger->log(\Zend\Log\Logger::DEBUG, $error->getMessage());
            $view = $twig->render('failed.html.twig');
        }
        $response = (new HtmlResponse($view))->withHeader('Refresh', '1; url=/');
		
		return $response;
    }
}