<?php

namespace App\Tests\Api\Functional;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ManageKeysTest extends AbstractApiTestCase
{
    public function testListKeys(): void
    {
        $this->request('GET', '/api/keys');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @return mixed
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function testCreateKey()
    {
        $response = $this->request('POST', 'api/keys', [
            'name' => 'app.test'.time(),
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($response->getContent(), true);

        return $data['@id'];
    }

    /**
     * @depends testCreateKey
     *
     * @param string|null $id
     *
     * @throws TransportExceptionInterface
     */
    public function testRetrieveKeys($id): void
    {
        $this->request('GET', $id);
        $this->assertResponseIsSuccessful();
    }

    /**
     * @depends testCreateKey
     *
     * @param string|null $id
     *
     * @throws TransportExceptionInterface
     */
    public function testRenameKeys($id): void
    {
        $this->request('PATCH', $id, [
            'name' => 'app.test'.time(),
        ]);

        $this->assertResponseIsSuccessful();
    }

    /**
     * @depends testCreateKey
     *
     * @param string|null $id
     *
     * @throws TransportExceptionInterface
     */
    public function testDeleteKeys($id): void
    {
        $this->request('DELETE', $id);
        $this->assertResponseIsSuccessful();
    }
}
