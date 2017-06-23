<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImageControllerTest extends WebTestCase
{
    public function testGetimages()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/getImages');
    }

}
