<?php declare(strict_types=1);

namespace App;

use App\Views\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Renderer
{
    private Environment $twig;
    private SessionManager $sessionManager;

    public function __construct(SessionManager $sessionManager)
    {
        $loader = new FilesystemLoader('../app/Views');
        $this->twig = new Environment($loader);
        $this->sessionManager = $sessionManager;
    }

    public function render(View $view): string
    {
        $this->twig->addGlobal('errors', $_SESSION['errors']);
        $this->twig->addGlobal('sessionId', $this->sessionManager->get());
        return $this->twig->render($view->getTemplate() . '.twig', $view->getVariables());
    }
}

