<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PersonTest extends WebTestCase
{
    public function testUpdateCategory(): void
    {
        $client = static::createClient();

        $crawler = $client->request('PUT', '/api/persona/3', [], [], [], json_encode([
            'name' => 'allenson',
            'birthday' => '2017/03/08',
        ]));

        $this->assertResponseIsSuccessful();

        $content = $client->getResponse()->getContent();

        $this->assertStringContainsString('3', $content);
        $this->assertStringContainsString('allenson', $content);
        $this->assertStringContainsString('2017\/03\/08', $content);
    }

    public function testUpdateCategoryError(): void
    {
        $client = static::createClient();

        $crawler = $client->request('PUT', '/api/persona/3', [], [], [], json_encode([
            'name' => 'allenson',
            'birthday' => '2017/33/08',
        ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);

        $content = $client->getResponse()->getContent();

        $this->assertStringContainsString('errors', $content);
    }
}
