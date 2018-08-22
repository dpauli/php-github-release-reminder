<?php
declare(strict_types=1);

namespace GhRelease\Connection;

use GhRelease\Connection\Request\AuthorizationRequest;
use GhRelease\Exception\NotConfiguredException;
use GhRelease\Helper\Configuration;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

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
     * @throws NotConfiguredException Required parameter are not configured.
     * @throws GuzzleException
     */
    public function authorize(): void
    {
        if ($this->token === null) {
            throw new NotConfiguredException(self::MESSAGE_TOKEN_CONFIG);
        }
        $request = new AuthorizationRequest();
        $request = $request->withHeader(self::AUTH_HEADER_NAME, sprintf(self::AUTH_HEADER_VALUE, $this->token));
        $client = new GuzzleClient();
        var_dump($request);
        $promise = $client->send($request);
        var_dump($promise->getBody()->getContents());
    }
}
