<?php

declare(strict_types=1);

namespace Effectra\Tracker\Contracts;

use Psr\Http\Client\ClientInterface;

/**
 * Interface ServiceInterface
 *
 * This interface defines the contract for classes implementing IP tracking services.
 */
interface ServiceInterface
{
    /**
     * ServiceInterface constructor.
     *
     * @param ClientInterface $client The HTTP client to make the API request.
     * @param string $ip The IP address to query.
     * @param string $apiKey The API key for authentication.
     * @throws \Exception If an error occurs during the API request.
     */
    public function __construct(ClientInterface $client, string $ip, string $apiKey);

    /**
     * Get all attributes from the IP tracking service response.
     *
     * @return array All attributes from the IP tracking service response.
     */
    public function getAll(): array;
}
