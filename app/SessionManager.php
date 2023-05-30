<?php declare(strict_types=1);

namespace App;

class SessionManager
{
    public static function start()
    {
        session_start();
    }

    public static function has(): bool
    {
        return isset($_SESSION['id']);
    }

    public static function set(int $value): void
    {
        $_SESSION['id'] = $value;
    }

    public static function get(): ?int
    {
        return $_SESSION['id'] ?? null;
    }

    public static function remove(): void
    {
        unset($_SESSION['id']);
    }

}
