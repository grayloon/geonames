<?php

namespace Grayloon\Geonames;

use Http\Client\HttpClient;
use Http\Discovery\UriFactoryDiscovery;
use Grayloon\Geonames\HttpClient\Builder;
use Grayloon\Geonames\Api\PostalCodeSearch;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Grayloon\Geonames\Exception\BadMethodCallException;
use Grayloon\Geonames\Exception\InvalidArgumentException;

/**
 * GeoNames API Client.
 *
 * @link http://www.geonames.org/export/ws-overview.html
 * @link http://www.geonames.org/export/web-services.html
 *
 * @method App\PostalCodeSearch postalCodeSearch()
 */
class Geonames
{
    /**
      * URL of the GeoNames web service.
      *
      * @var  string  $url
      */
    protected $url = 'https://secure.geonames.org';

    /**
     * GeoNames Authorization username.
     *
     * @see http://www.geonames.org/commercial-webservices.html
     *
     * @var  string  $username
     */
    protected $username;

    /**
     * Create a new GeoNames instance.
     *
     * @param string $username
     * @param string $token
     * @param Builder|null $httpClientBuilder
     */
    public function __construct($username, Builder $httpClientBuilder = null)
    {
        $this->username = $username;
        $this->httpClientBuilder = $builder = $httpClientBuilder ?: new Builder();

        $builder->addPlugin(new RedirectPlugin());
        $builder->addPlugin(new AddHostPlugin(UriFactoryDiscovery::find()->createUri($this->url)));
    }

    /**
     * @param string $method
     *
     * @throws BadMethodCallException
     *
     * @return ApiInterface
     */
    public function __call($method, $args)
    {
        try {
            return $this->api($method, $args[0] ?? []);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s"', $method));
        }
    }

    /**
     * Create a Geonames instance using a HttpClient.
     *
     * @param HttpClient $httpClient
     *
     * @return Client
     */
    public static function createWithHttpClient($username, HttpClient $httpClient)
    {
        $builder = new Builder($username, $httpClient);

        return new self($builder);
    }

    /**
     * @param string $method
     *
     * @throws InvalidArgumentException
     *
     * @return ApiInterface
     */
    public function api($method, $args = [])
    {
        $args['username'] = $this->username;

        switch ($method) {
            case 'postalCodeSearch':
                $api = new PostalCodeSearch($this, $args);
                break;

            //TODO: Add the rest of the methods.

            default:
                throw new InvalidArgumentException(sprintf('Undefined API instance called: "%s"', $method));
        }

        return $api->result;
    }

    /**
     * @return HttpMethodsClient
     */
    public function getHttpClient()
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    /**
     * @return Builder
     */
    protected function getHttpClientBuilder()
    {
        return $this->httpClientBuilder;
    }
}
