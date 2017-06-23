<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TagControllerTest extends WebTestCase
{
    public function testTags()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tags');
    }

    public function testAddtag()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addTag');
    }

    public function testUpdatetag()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateTag');
    }

    public function testTag()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/tag');
    }

}
