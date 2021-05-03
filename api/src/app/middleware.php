<?php

declare(strict_types=1);

use SearchApi\Application\Middleware\CorsMiddleware;
use Slim\App;

return function (App $app) {
    $app->add(CorsMiddleware::class);
};
