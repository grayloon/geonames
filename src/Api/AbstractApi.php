<?php

namespace Grayloon\Geonames\Api;

use Grayloon\Geonames\Geonames;
use Grayloon\Geonames\HttpClient\Message\ResponseMediator;

abstract class AbstractApi implements ApiInterface
{
    /**
     * The Geonames client.
     *
     * @var Client
     */
    protected $client;

    /**
     * The result from the query.
     *
     * @var array
     */
    public $result;

    /**
     * @param Geonames $client
     */
    public function __construct(Geonames $client, $args = [])
    {
        $this->client = $client;
        $this->args = $args;

        $this->result = $this->get();
    }

    /**
     * Send a GET request with query parameters.
     *
     *
     * @return array|string
     */
    protected function get()
    {
        $path = urldecode($this->class_basename().'?'.http_build_query($this->args));
        
        $response = $this->client->getHttpClient()->get($path);

        return ResponseMediator::getContent($response);
    }

    /**
     * The class short unqualified name.
     *
     * @return string
     */
    protected function class_basename()
    {
        return lcfirst(basename(str_replace('\\', '/', get_class($this))));
    }
}
