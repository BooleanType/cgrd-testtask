<?php

declare(strict_types=1);

namespace App\Controller;

use App\Flash;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Controller
{
    private Environment $twig;
    private ?array $flash;

    public function __construct()
    {
        static $twig = null;
        
        if ($twig === null) {
            $loader = new FilesystemLoader(__DIR__ . '/../../templates');
            $twig = new Environment($loader, [
                'cache' => false,
            ]);
        }
        
        $this->twig = $twig;
        $this->flash = Flash::get();
        
        $this->before();
    }

    protected function before(): void
    {
    }
    
    protected function render(string $template, array $params = []): void
    {
        echo $this->twig->render($template, [...['flash' => $this->flash], ...$params]);
    }
    
    protected function redirect(string $location): void
    {
        header("Location: /$location");
        
        exit;
    }
}
