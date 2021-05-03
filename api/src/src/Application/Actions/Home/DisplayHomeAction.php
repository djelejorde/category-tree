<?php

declare(strict_types=1);

namespace SearchApi\Application\Actions\Home;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DisplayHomeAction
{
    public function __invoke(Request $request, Response $response)
    {
        $response->getBody()->write('Hello');

        return $response;
    }
}
