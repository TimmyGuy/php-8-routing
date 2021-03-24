<?php

use Router\Demo\Core\Application;

require_once dirname(__DIR__).'/MVC/Core/Application.php';

$app = new Application();
$app->resolve();