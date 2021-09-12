<?php

namespace App\Tests\Api\Functional;

class ExportAllTest extends AbstractApiTestCase
{
    public function testExportJson(): void
    {
        $this->request('GET', '/api/export/json');

        $this->assertResponseIsSuccessful();
    }

    public function testExportYaml(): void
    {
        $this->request('GET', '/api/export/yaml');

        $this->assertResponseIsSuccessful();
    }
}
