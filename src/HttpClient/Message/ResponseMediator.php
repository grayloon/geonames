<?php

namespace Grayloon\Geonames\HttpClient\Message;

use Psr\Http\Message\ResponseInterface;

class ResponseMediator
{
    /**
     * @param ResponseInterface $response
     *
     * @return array|string
     */
    public static function getContent(ResponseInterface $response)
    {
        $body = $response->getBody()->__toString();

        libxml_use_internal_errors(true);
        if (! simplexml_load_string($body)) {
            return $body;
        }

        return json_decode(json_encode((array)simplexml_load_string($body)), true);
    }
}
