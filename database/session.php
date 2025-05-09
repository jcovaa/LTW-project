<?php
declare(strict_types=1);
require_once(__DIR__ . '/../database/user.class.php');


class Session {
    private static ?Session $instance = null;

    public static function getInstance(): Session {
        if (self::$instance === null) {
            self::$instance = new Session();
        }

        return self::$instance;
    }

    public function __construct() {
        session_start();
    }

    public function getUser() {
        return $_SESSION["user"] ?? null;
    }

    public function login($user) {
        $_SESSION["user"] = $user;
    }

    public function isLoggedIn(): bool {
        return isset($_SESSION["user"]);
    }

    public function getUserId(): ?int {
        $user = $this->getUser();
        return $user ? $user->id : null;
    }

    public function logout() {
        session_destroy();
    }
}
?>