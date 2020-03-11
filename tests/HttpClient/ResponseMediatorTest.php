<?php

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Grayloon\Geonames\HttpClient\Message\ResponseMediator;

class ResponseMediatorTest extends TestCase
{
    public function test_it_can_get_content()
    {
        $body = <<<'TEXT'
<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<geonames>
    <totalResultsCount>1</totalResultsCount>
    <code>
        <postalcode>47579</postalcode>
        <name>Santa Claus</name>
        <countryCode>US</countryCode>
        <lat>38.11758</lat>
        <lng>-86.92865</lng>
        <adminCode1 ISO3166-2="IN">IN</adminCode1>
        <adminName1>Indiana</adminName1>
        <adminCode2>147</adminCode2>
        <adminName2>Spencer</adminName2>
        <adminCode3/>
        <adminName3/>
    </code>
</geonames>
TEXT;

        $response = new Response(
            200,
            ['Content-Type'=>'application/xml'],
            \GuzzleHttp\Psr7\stream_for($body)
        );

        $content = ResponseMediator::getContent($response);


        $this->assertIsArray($content);
        $this->assertIsArray($content['code']);
        $this->assertEquals('47579', $content['code']['postalcode']);
    }

    public function test_it_does_not_format_non_xml()
    {
        $body = 'foobar';

        $response = new Response(
            200,
            ['Content-Type'=>'application/xml'],
            \GuzzleHttp\Psr7\stream_for($body)
        );

        $content = ResponseMediator::getContent($response);

        $this->assertIsNotArray($content);
        $this->assertEquals('foobar', $content);
    }
}
