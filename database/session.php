<?php

declare(strict_types=1);
require_once(__DIR__ . '/../database/user.class.php');


class Session
{
    private static ?Session $instance = null;

    public static function getInstance(): Session
    {
        if (self::$instance === null) {
            self::$instance = new Session();
        }

        return self::$instance;
    }

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['messages'])) {
            $_SESSION['messages'] = [];
        }
    }

    public function getUser()
    {
        return $_SESSION["user"] ?? null;
    }

    public function login($user)
    {
        $_SESSION["user"] = $user;
        $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION["user"]);
    }

    public function getUserId(): ?int
    {
        $user = $this->getUser();
        return $user ? $user->id : null;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

    public function addMessage(string $type, string $text)
    {
        $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
    }

    public function getMessages(): array
    {
        $messages = $_SESSION['messages'] ?? [];
        $_SESSION['messages'] = []; // Clear after retrieval
        return $messages;
    }

    public function getCSRFToken(): string
    {
        return $_SESSION['csrf'] ?? '';
    }

    public function validateCSRFToken(string $token): bool
    {
        return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
    }
}
