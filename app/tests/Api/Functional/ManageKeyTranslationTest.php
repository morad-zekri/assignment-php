<?php

namespace App\Tests\Api\Functional;

class ManageKeyTranslationTest extends AbstractApiTestCase
{
    public function testManageTranslation(): void
    {
        $response = $this->request('GET', '/api/translations');

        $data = json_decode($response->getContent(), true);
        $translation = $data['hydra:member'][0];
        $translation['textValue'] = 'update translation';
        $this->request('PATCH', $translation['@id'], $translation);

        $this->assertResponseIsSuccessful();
    }
}
