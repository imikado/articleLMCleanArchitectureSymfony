<?php 

namespace Infrastructure\Symfony\Presenter;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class PresenterToHtml{

    protected $twig;

    public function __construct( )
    {
        $loader = new FilesystemLoader('../src/Infrastructure/Twig/templates');
        $this->twig = new Environment($loader, [
            'cache' => '../var/cache/twig',
        ]);
    }

}