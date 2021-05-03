<?php

declare(strict_types=1);

namespace SearchApi\Application\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Slim\Psr7\Response;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use Psr\Log\LoggerInterface;
use SearchApi\Application\Settings\SettingsInterface;

class BearerAuthMiddleware implements Middleware
{
    private $jwtSettings;
    private $logger;

    public function __construct(
        SettingsInterface $settings,
        LoggerInterface $logger
    ) {
        $this->jwtSettings = $settings->get('jwt');
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $serverParams = $request->getServerParams();

        if (
            !isset($serverParams['HTTP_AUTHORIZATION'])
            || !preg_match('/Bearer\s(\S+)/', $serverParams['HTTP_AUTHORIZATION'], $matches)
            || empty($matches[1])
        ) {
            return $this->getUnauthorizedResponse('Unauthorized access. Unknown token.');
        }
        
        if (!$this->checkTokenIfValid($matches[1])) {
            return $this->getUnauthorizedResponse('Unauthorized access. Invalid token.');
        }

        if (!$this->checkTokenIfNotExpired($matches[1])) {
            return $this->getUnauthorizedResponse('Unauthorized access. Token expired.');
        }

        return $handler->handle($request);
    }

    private function checkTokenIfValid(string $jwt): bool
    {
        return $this->getDecodedToken($jwt)->iss == $this->jwtSettings['domain'];
    }

    private function checkTokenIfNotExpired(string $jwt)
    {
        return $this->getDecodedToken($jwt)->exp > (new DateTimeImmutable())->getTimestamp();
    }

    private function getDecodedToken(string $jwt): object
    {
        return JWT::decode(
            $jwt,
            $this->jwtSettings['secret'],
            [$this->jwtSettings['algo']]
        );
    }

    private function getUnauthorizedResponse(string $message): Response
    {
        $response = (new Response())
            ->withStatus(401, 'Unauthorized')
        ;

        $this->logger->warning($message);

        $response->getBody()->write($message);

        return $response;
    }
}