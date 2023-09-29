<?php

declare(strict_types=1);

namespace Effectra\Tracker\Services;

use Effectra\Tracker\Attribute;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;

/**
 * Class IpWhoIs
 *
 * This class provides methods to interact with the ipwho.is API and access various attributes
 * from the API response.
 *
 * @package Effectra\Tracker\Services
 */
class IpWhoIs extends Attribute
{
    /**
     * The base URL for the ipwho.is API.
     *
     * @var string
     */
    protected string $service_url = "http://ipwho.is/";

    /**
     * IpWhoIs constructor.
     *
     * @param ClientInterface $client The HTTP client to make the API request.
     * @param string $ip The IP address to query.
     * @param string $apiKey The API key for authentication (not used in this implementation).
     * @throws \Exception If an error occurs during the API request.
     */
    public function __construct(ClientInterface $client, string $ip, string $apiKey)
    {
        try {
            $url = "{$this->service_url}/{$ip}";

            $response = $client->sendRequest(new Request('GET', $url));

            $this->attributes = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Get all attributes from the API response.
     *
     * @return array All attributes from the API response.
     */
    public function getAll(): array
    {
        return $this->getAttributes();
    }
}
