<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUsers()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/users');
    }

    public function testAdduser()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addUser');
    }

}
