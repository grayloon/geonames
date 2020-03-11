<?php

namespace Grayloon\Geonames\Tests\Api;

use Grayloon\Geonames\Geonames;
use PHPUnit\Framework\TestCase;

class PostalCodeSearchTest extends TestCase
{
    public function test_it_can_postal_code_search()
    {
        $geonames = new Geonames('grayloon_hoyt');

        $result = $geonames->postalCodeSearch([
            'country' => 'US',
            'postalcode' => '47579',
        ]);

        $this->assertIsArray($result);
    }
}
