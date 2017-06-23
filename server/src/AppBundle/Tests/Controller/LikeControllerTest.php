<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LikeControllerTest extends WebTestCase
{
    public function testAddlike()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addLike');
    }

    public function testRemovelike()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/removeLike');
    }

}
