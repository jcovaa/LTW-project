<?php

declare(strict_types=1);

class Admin
{
    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public static function isAdmin(PDO $db, int $userId)
    {
        $stmt = $db->prepare('SELECT 1 FROM Admin WHERE UserId = ?');
        $stmt->execute([$userId]);
        return $stmt->fetchColumn() !== false;
    }


    public static function getAdmins(PDO $db)
    {
        $stmt = $db->prepare('SELECT UserId FROM Admin');
        $stmt->execute();

        $admins = [];
        while ($admin = $stmt->fetch()) {
            $admins[] = new Admin($admin['UserId']);
        }

        return $admins;
    }

    public static function elevateToAdmin(PDO $db, int $userId): bool
    {
        $stmt = $db->prepare('INSERT INTO Admin (UserId) VALUES (?)');
        try {
            return $stmt->execute([$userId]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function createCategory(PDO $db, string $name): bool
    {
        $stmt = $db->prepare('INSERT INTO Category (Name) VALUES (?)');
        return $stmt->execute([$name]);
    }
}


?>
