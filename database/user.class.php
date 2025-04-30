<?php

declare(strict_types=1);

class User
{
    public int $id;
    public string $name;
    public string $username;
    public string $email;

    public function __construct(int $id, string $name, string $username, string $email) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
    }

    public static function create(PDO $db, $name, $username, $email, $password) {
        $stmt = $db->prepare('INSERT INTO User (Name, Username, Email, Password) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $username, $email, sha1($password)]);
    }
    
   

    public static function getUsers(PDO $db, int $count) : array
    {
        $stmt = $db->prepare('
        SELECT *
        FROM User   
        LIMIT ?
        ');
        $stmt->execute(array($count));

        $users = [];
        while ($user = $stmt->fetch()) {
            $users[] = new User(
                $user['UserId'],
                $user['Name'],
                $user['Username'],
                $user['Email'],
            );
        };

        return $users;
    }

    public static function getUser(PDO $db, int $id)
    {
        $stmt = $db->prepare('
        SELECT *
        FROM User   
        WHERE UserId = ?
    ');

        $stmt->execute([$id]);
        $user = $stmt->fetch();

        return new User(
            $user['UserId'],
            $user['Name'],
            $user['Username'],
            $user['Email']
        );
    }


    static function getUserWithPassword(PDO $db, string $email, string $password)  : ?User {
        $stmt = $db->prepare('
        SELECT UserId, Username, Name, Email
        FROM User 
        WHERE lower(email) = ? AND password = ?
      ');

      $stmt->execute(array(strtolower($email), sha1($password)));
  
      if ($user = $stmt->fetch())  {
        return new User(
            $user['UserId'],
            $user['Name'],
            $user['Username'],
            $user['Email'],
        );
      }
      
      return null;
    }



    
}

?>
