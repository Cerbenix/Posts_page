<?php declare(strict_types=1);

namespace App;

use Twig\Node\Expression\Binary\EndsWithBinary;

class RouteAccessManager
{
    private array $guestRoutes;
    private array $loggedInRoutes;
    private array $commonRoutes;

    public function __construct()
    {
        $this->guestRoutes = [
            '/login',
            '/user/register',
            '/user',
        ];

        $this->loggedInRoutes = [
            '/profile',
            '/profile/edit',
            '/logout',
            '/article/{id:\d+}/edit',
            '/article/delete/{id:\d+}',
            '/article/create',
            '/article/{id:\d+}/comment',
            '/article/{id:\d+}/comment/{commentId}/delete'
        ];

        $this->commonRoutes = [
            '/',
            '/error/{message}',
            '/article',
            '/error/{message}',
            '/article/{id:\d+}',
            '/user/{id:\d+}'
        ];
    }

    public function isRouteAccessible(string $uri, bool $isLoggedIn): bool
    {
        if (!$isLoggedIn && in_array($uri, $this->guestRoutes)) {
            return true;
        }
        if ($isLoggedIn) {
            foreach ($this->loggedInRoutes as $route) {
                $pattern = preg_replace('/\{.*?\}/', '\d+', $route);
                if (preg_match('#^' . $pattern . '$#', $uri)) {
                    return true;
                }
            }
        }
        foreach ($this->commonRoutes as $route) {
            $pattern = preg_replace('/\{.*?\}/', '\d+', $route);
            if (preg_match('#^' . $pattern . '$#', $uri)) {
                return true;
            }
        }
        return false;
    }

    public function redirect(bool $isLoggedIn): Redirect
    {
        if ($isLoggedIn){
            return New Redirect('/');
        }
        return new Redirect('/login');
    }
}