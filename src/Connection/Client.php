<?php
declare(strict_types=1);

namespace GhRelease\Connection;

use GhRelease\Connection\Request\LastReleaseRequest;
use GhRelease\Exception\NotConfiguredException;
use GhRelease\Helper\Configuration;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use RuntimeException;

/**
 * @author  david.pauli
 * @package GhRelease/Connection
 * @since   17.08.2018
 */
class Client
{
    use Configuration;

    private const AUTH_HEADER_NAME = 'Authorization';
    private const AUTH_HEADER_VALUE = 'Bearer %s';
    private const MESSAGE_TOKEN_CONFIG = 'Token is not configured.';

    /** @var string */
    protected $token;

    /**
     * @param  string $owner The owner of the repository.
     * @param  string $name  The name of the repository.
     * @return string|null The latest release version.
     * @throws GuzzleException
     * @throws NotConfiguredException Required parameter are not configured.
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function latestReleases(string $owner, string $name): ?string
    {
        if ($this->token === null) {
            throw new NotConfiguredException(self::MESSAGE_TOKEN_CONFIG);
        }

        /** @var LastReleaseRequest $request */
        $request = (new LastReleaseRequest($owner, $name))
            ->withHeader(self::AUTH_HEADER_NAME, sprintf(self::AUTH_HEADER_VALUE, $this->token));

        $promise = (new GuzzleClient())->send($request);
        $responseArray = json_decode($promise->getBody()->getContents(), true);
        return reset($responseArray['data']['repository']['releases']['nodes'])['tag']['name'] ?? null;
    }
}
