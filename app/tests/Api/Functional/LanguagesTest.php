<?php

namespace App\Tests\Api\Functional;

class LanguagesTest extends AbstractApiTestCase
{
    public function testListLanguages(): void
    {
        $this->request('GET', '/api/languages');
        $this->assertResponseIsSuccessful();
    }
}
