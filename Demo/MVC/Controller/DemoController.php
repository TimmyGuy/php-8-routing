<?php

namespace Routing\Controller;

use Routing\Attribute\Route;

require_once('Attribute/Route.php');

class DemoController
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

    #[Route('/view/{foo}')]
    function view($foo)
    {
        echo "Hello! You are viewing {$foo}";
    }
}
