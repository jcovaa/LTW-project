<?php

declare(strict_types=1);

class User
{
    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public string $password;

    public function __construct(int $id, string $name, string $username, string $email, string $password) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
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
                $user['password'],
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
            $user['Email'],
            $user['Password'],
        );
    }



    
}

?>
