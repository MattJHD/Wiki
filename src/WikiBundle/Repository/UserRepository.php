<?php
namespace WikiBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Description of UserRepository
 *
 * @author williambloch
 */
class UserRepository extends EntityRepository{

  // Query - Get all Users
  public function getAllUsers(){
    $qb = $this->_em->createQueryBuilder()
            ->select('user')
            ->from("WikiBundle:User", "user");
    $query = $qb->getQuery();
    $results = $query->getResult();
    return $results;
  }

  // Query - Get a single User
  public function getOneUser($id){
    $qb = $this->_em->createQueryBuilder()
              ->select("user")
              ->from("WikiBundle:User", "user")
              ->andWhere("user.id = :id")
              ->setParameter("id", $id);
      $query = $qb->getQuery();
      $results = $query->getResult();
      return $results;
  }

  // Query - Insert User in Db
  public function createUser($em, $user){
    $RAW_QUERY = 'INSERT
                  INTO USER (role_id, firstname, lastname, username, salt, password, email)
                  VALUES ("'.$user->getRole()->getId().'", "'.$user->getFirstname().'", "'.$user->getLastname().'", "'.$user->getUsername().'", "'.$user->getSalt().'", "'.$user->getPassword().'", "'.$user->getEmail().'");';
    $statement = $em->getConnection()->prepare($RAW_QUERY);
    $result = $statement->execute();

    return $result;
  }

  // Query - Update User in Db
  public function updateUser($id, $user){
    $role_id = $user->getRole()->getId();
    $firstname = $user->getFirstname();
    $lastname = $user->getLastname();
    $username = $user->getUsername();
    $salt = $user->getSalt();
    $password = $user->getPassword();
    $email = $user->getEmail();


    $qb = $this->_em->createQueryBuilder()
              ->update("WikiBundle:User", "user")
              ->set("user.role", ":role_id")
              ->set("user.firstname", ":firstname")
              ->set("user.lastname", ":lastname")
              ->set("user.username", ":username")
              ->set("user.salt", ":salt")
              ->set("user.password", ":password")
              ->set("user.email", ":email")
              ->andWhere("user.id = :id")
              ->setParameter("id", $id)
              ->setParameter("role_id", $role_id)
              ->setParameter("firstname", $firstname)
              ->setParameter("lastname", $lastname)
              ->setParameter("username", $username)
              ->setParameter("salt", $salt)
              ->setParameter("password", $password)
              ->setParameter("email", $email);
      $query = $qb->getQuery();
      $results = $query->getResult();
      return $results;
  }
}
