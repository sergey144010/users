<?php

namespace sergey144010\users\User;


use sergey144010\users\User\Name;
use sergey144010\users\User\Mail;
use sergey144010\users\User\Phone;

class User implements UserInterface
{
    private $id;
    private $name;
    private $mail;
    private $phone;

    public function __construct(Name $name, Mail $mail, Phone $phone)
    {
        $this->name = $name->get();
        $this->mail = $mail->get();
        $this->phone = $phone->get();
    }

    public function getId()
    {
        return $this->id;
    }
	
    public function getName()
    {
        return $this->name;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getPhone()
    {
        return $this->phone;
    }
	
    public function setId($id)
    {
        if(empty($this->id)){
            $this->id = $id;
        };
    }
}