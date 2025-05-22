<?php

declare(strict_types=1);

class User
{
    public int $id;
    public string $name;
    public string $username;
    public string $email;

    public function __construct(int $id, string $name, string $username, string $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
    }

    public static function create(PDO $db, $name, $username, $email, $password)
    {
        $options = ['cost' => 12];
        $stmt = $db->prepare('INSERT INTO User (Name, Username, Email, Password) VALUES (?, ?, ?, ?)');
        return $stmt->execute([ 
            $name, 
            $username, 
            $email, 
            password_hash($password, PASSWORD_DEFAULT, $options)
        ]);
    }



    public static function getUsers(PDO $db, int $count): array
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


    static function getUserWithPassword(PDO $db, string $email, string $password): ?User
    {
        $stmt = $db->prepare('
        SELECT *
        FROM User 
        WHERE lower(email) = ?;
      ');

        $stmt->execute([strtolower($email)]);

        if ($user = $stmt->fetch()) {
            if (password_verify($password, $user['Password'])) {
                return new User(
                    $user['UserId'],
                    $user['Name'],
                    $user['Username'],
                    $user['Email'],
                );
            }
        }

        return null;
    }

    public static function exists(PDO $db, string $email, string $username): bool
    {
        $stmt = $db->prepare('SELECT UserId FROM User WHERE Email = ? OR Username = ?');
        $stmt->execute([$email, $username]);
        return $stmt->fetch() !== false;
    }
}
