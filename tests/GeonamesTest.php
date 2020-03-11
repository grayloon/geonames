<?php

namespace Grayloon\Geonames\Tests;

use ArgumentCountError;
use Http\Client\HttpClient;
use Grayloon\Geonames\Geonames;
use Grayloon\Geonames\Exception\BadMethodCallException;
use Grayloon\Geonames\Exception\InvalidArgumentException;

class GeonamesTest extends TestCase
{
    public function test_should_not_have_to_pass_http_client_to_constructor()
    {
        $geonames = new Geonames('foo');

        $this->assertInstanceOf(HttpClient::class, $geonames->getHttpClient());
    }

    public function test_geonames_should_expect_username_on_constructor()
    {
        $this->expectException(ArgumentCountError::class);

        $geonames = new Geonames();
    }

    public function test_it_should_Not_get_api_instance()
    {
        $this->expectException(InvalidArgumentException::class);

        $geonames = new Geonames('foo');
        $geonames->api('do_not_exist');
    }

    public function test_it_should_not_get_magic_api_instance()
    {
        $this->expectException(BadMethodCallException::class);
        $geonames = new Geonames('foo');
        $geonames->doNotExist();
    }
}
