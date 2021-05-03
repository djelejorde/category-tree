<?php

declare(strict_types=1);

namespace SearchApi\Application\Actions\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use SearchApi\Application\Actions\Action;
use Firebase\JWT\JWT;
use DateTimeImmutable;
use SearchApi\Application\Settings\SettingsInterface;

class CreateTokenAction extends Action
{
    private $jwtSettings;

    public function __construct(SettingsInterface $settings)
    {
        $this->jwtSettings = $settings->get('jwt');
    }

    protected function action(): Response
    {
        $expiration = (new DateTimeImmutable("now +2 hours"))->getTimeStamp();

        return $this->respondWithData([
            'token' => JWT::encode(
                [
                    'iat' => (new DateTimeImmutable())->getTimeStamp(),
                    'exp' => $expiration,
                    'iss' => $this->jwtSettings['domain']
                ],
                $this->jwtSettings['secret'],
                $this->jwtSettings['algo']
            ),
            'expires' => $expiration
        ]);
    }
}