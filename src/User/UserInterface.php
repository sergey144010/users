<?php

namespace sergey144010\users\User;

interface UserInterface
{
    public function getId();
    public function getName();
    public function getMail();
    public function getPhone();
}