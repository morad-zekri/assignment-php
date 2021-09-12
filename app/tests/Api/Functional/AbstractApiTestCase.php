<?php

namespace App\Tests\Api\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class AbstractApiTestCase extends ApiTestCase
{
    /**
     * @var string
     */
    protected $token;

    public function setUp(): void
    {
        $response = static::createClient()->request(
            'POST',
            '/authentication_token', ['json' => [
                'username' => 'admin',
                'password' => 'admin',
            ]]
        );

        $this->token = 'Bearer '.json_decode($response->getContent(), true)['token'];

        parent::setUp();
    }

    /**
     * @param string $method
     * @param string $url
     * @param mixed  $data
     *
     * @return ResponseInterface
     *
     * @throws TransportExceptionInterface
     */
    protected function request($method, $url, $data = null)
    {
        $headers['Authorization'] = $this->token;
        if ('PATCH' === $method) {
            $headers['Content-Type'] = 'application/merge-patch+json';
        }

        return static::createClient()->request(
            $method,
            $url,
            [
                'headers' => $headers,
                'json' => $data,
            ]
        );
    }
}
