<?php

namespace Routing\Controller;

use Routing\Attribute\Route;

require_once('Attribute/Route.php');

#[Route('/prefix')]
class PrefixedController
{
    #[Route('/foo')]
    function foo()
    {
        echo "I'm located at `/prefix/foo`";
    }

    #[Route('/bar')]
    function bar() {
        echo "I'm located at `/prefix/bar`";
    }
}
