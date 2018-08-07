<?php

namespace sergey144010\users\User;

use sergey144010\users\Exception\ValidateException;
use Zend\Validator\Regex;

class Phone
{
    private $phone;

    public function __construct($phone)
    {
        $validator = new Regex(['pattern' => '/^\+?\d+$/']);
        if($validator->isValid($phone)){
            $this->phone = $phone;
        } else {
            throw new ValidateException('Error Phone validation');
        }
    }

    public function get()
    {
        return $this->phone;
    }
}