<?php

namespace sergey144010\users\Repository;


use sergey144010\users\Exception\InsertIntoUsersException;
use sergey144010\users\Exception\NotFoundException;
use sergey144010\users\Exception\UserException;
use sergey144010\users\Exception\UpdateUserException;

use sergey144010\users\User\Name;
use sergey144010\users\User\Mail;
use sergey144010\users\User\Phone;
use sergey144010\users\User\UserInterface;
use sergey144010\users\User\User;

class UserRepository extends AbstractRepository
{
    /**
     * @param UserInterface $user
     * @return void
     * @throws UserException
     */
    public function save(UserInterface $user)
    {
        $name = $user->getName();
        $mail = $user->getMail();
        $phone = $user->getPhone();

        $this->pdo->beginTransaction();
        $stmt = $this->pdo->prepare("INSERT INTO users (name, mail, phone) VALUES (:name, :mail, :phone);");

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':phone', $phone);
        if(!$stmt->execute()){
            throw new InsertIntoUsersException('Error insert in users table');
        };
        $this->pdo->commit();
    }

    public function remove(int $id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function update(UserInterface $user)
    {
		$id = $user->getId();
        $name = $user->getName();
        $mail = $user->getMail();
        $phone = $user->getPhone();
		
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name, mail = :mail, phone = :phone WHERE id = :id");
		
		$stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':phone', $phone);
		
        if(!$stmt->execute()){
            throw new UpdateUserException('Error update users table');
        };
    }
	
	public function get(int $id): User
	{
		$stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
		$stmt->bindParam(':id', $id);
        $stmt->execute();
		$row = $stmt->fetchAll();
		if(empty($row)){
		    throw new NotFoundException();
        };
		$user = new User(
			new Name($row[0]['name']),
			new Mail($row[0]['mail']),
			new Phone($row[0]['phone'])
		);
		$user->setId($row[0]['id']);
		return $user;
	}
	
	public function getList(int $limit = null, int $offset = null)
	{		
		$sql = "SELECT * FROM users ORDER BY id DESC";
		if(isset($limit)){
			$sql .= " LIMIT :limit";
		};
		if(isset($offset)){
			$sql .= " OFFSET :offset";
		};
		$stmt = $this->pdo->prepare($sql);
		if(isset($limit)){$stmt->bindParam(':limit', $limit);};
		if(isset($offset)){$stmt->bindParam(':offset', $offset);};
		$stmt->execute();
		$row = $stmt->fetchAll();
		return $row;
	}
	
    public function has(int $id): bool
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE id = :id;");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetchAll(\PDO::FETCH_NUM);
        if($row[0][0] == 0){
            return false;
        }else{
            return true;
        }
    }
}