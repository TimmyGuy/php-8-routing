<?php

namespace Router\Controller;

use Short\Attribute\Route;


#[Route('/prefix')]
class PrefixedController
{
    #[Route('/')]
    function foo()
    {
        echo "I'm located at `/prefix`";
    }

    #[Route('/bar')]
    function bar() {
        echo "I'm located at `/prefix/bar`";
    }
}
