<?php

namespace sergey144010\users\Repository;

use sergey144010\users\User\UserInterface;
use sergey144010\users\User\User;

interface RepositoryInterface
{
    public function save(UserInterface $user);
    public function remove(int $id);
    public function update(UserInterface $user);

    public function get(int $id): User;
    public function getList(int $limit = null, int $offset = null);

    public function has(int $id): bool;
}