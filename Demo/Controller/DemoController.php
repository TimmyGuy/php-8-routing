<?php

namespace Router\Demo\Controller;

use Short\Attribute\Route;

require_once(dirname(__DIR__, 2).'/Attribute/Route.php');

class HomeController
{
    #[Route('/')]
    function index()
    {
        echo "Hello! I'm the homepage of this website";
    }

    #[Route('/about')]
    function about() {
        echo "Hello! I'm the about page of this website";
    }
}
