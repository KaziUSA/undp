<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MapControllerTest extends WebTestCase
{
    public function testNepal()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/nepal');
    }

}
