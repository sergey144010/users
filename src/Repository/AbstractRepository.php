<?php

namespace sergey144010\users\Repository;


abstract class AbstractRepository implements RepositoryInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        if(!isset($this->pdo)){
            $this->pdo = $pdo;
        }
    }
}