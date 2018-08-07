<?php

namespace sergey144010\users\User;


use sergey144010\users\Exception\ValidateException;
use Zend\Validator\EmailAddress;

class Mail
{
    private $mail;

    public function __construct($mail)
    {
        $validator = new EmailAddress();
        if ($validator->isValid($mail)) {
            $this->mail = $mail;
        } else {
            throw new ValidateException('Error mail validation');
        }
    }

    public function get()
    {
        return $this->mail;
    }
}