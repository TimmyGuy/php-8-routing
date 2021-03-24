<?php

use Routing\Core\Router;

require_once 'Core/Router.php';

// url: /
Router::register('/', function () {
    echo "Hello, I'm the home page";
});

// url: /view/account
Router::register('/view/{bar}', function ($bar) {
    echo "Hello, you're viewing {$bar}"; // Hello, you're viewing account
});

// url: /view/acount
Router::register('/view/{foo}', function ($bar) {
    // This won't work as foo != bar
});

// url: /add/peanut/5
Router::register('/add/{foo}/{bar}', function ($bar, $foo) {
    // This will work as foo == foo && bar == bar

    echo $bar; // 5
    echo $foo; // peanut
});

Router::run();