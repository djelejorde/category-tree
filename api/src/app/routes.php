<?php

declare(strict_types=1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy as Group;
use SearchApi\Application\Middleware\BearerAuthMiddleware;
use SearchApi\Application\Actions\Home\DisplayHomeAction;
use SearchApi\Application\Actions\Category\GetCategoriesAction;
use SearchApi\Application\Actions\Category\GetCategoryAction;
use SearchApi\Application\Actions\Category\GetChildCategoriesAction;
use SearchApi\Application\Actions\Auth\CreateTokenAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (App $app) {
    $app->get('/', DisplayHomeAction::class);

    $app->post('/api/token', CreateTokenAction::class);
    $app->options('/api/token', function (Request $request, Response $response): Response { 
        return $response; 
    });

    // Allow preflight requests
    // Due to the behaviour of browsers when sending a request,
    // you must add the OPTIONS method. Read about preflight.
    // $app->options('/api/categories', function (Request $request, Response $response): Response {
    //     // Do nothing here. Just return the response.
    //     return $response;
    // });
    $app->options('', function (Request $request, Response $response): Response {
        return $response;
    });
    $app->group('/api', function(Group $group) {
        $group->options('', function (Request $request, Response $response): Response {
            return $response;
        });

        $group->get('/categories', GetCategoriesAction::class);
        $group->options('/categories', function (Request $request, Response $response): Response { 
            return $response; 
        });

        $group->group('/category', function(Group $subGroup) {
            $subGroup->get('/{id:[0-9]+}', GetCategoryAction::class);
            $subGroup->get('/{id:[0-9]+}/children', GetChildCategoriesAction::class);
        });
    })->add(BearerAuthMiddleware::class);
};
