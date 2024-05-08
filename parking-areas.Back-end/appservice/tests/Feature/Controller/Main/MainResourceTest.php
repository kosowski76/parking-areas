<?php
namespace App\Tests\Feature\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainResourceTest extends WebTestCase
{
    public function testManiDashboard(): void
    {
        $client = static::createClient([],
        [
            'HTTP_HOST' => '127.0.0.1',
        ]);

        $crawler = $client->request('GET', '/');

        // Validate a successful response and some content
        $this->assertResponseIsSuccessful();
    }

}