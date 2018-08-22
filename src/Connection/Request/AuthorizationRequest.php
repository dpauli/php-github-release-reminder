<?php
declare(strict_types=1);

namespace GhRelease\Connection\Request;

use GraphQL\RequestBuilder\RootType;
use GraphQL\RequestBuilder\Type;
use GuzzleHttp\Psr7\Request;

/**
 * @author  david.pauli
 * @package GhRelease\Connection\Request
 * @since   17.08.2018
 */
class AuthorizationRequest extends Request
{
    private const METHOD = 'POST';
    private const URI = 'https://api.github.com/graphql';
    private const HEADERS = ['Content-Type' => 'application/json'];

    public function __construct()
    {
        parent::__construct(self::METHOD, self::URI, self::HEADERS, $this->createPayload());
    }

    /**
     * Creates the payload to authenticate.
     *
     * @return string
     */
    private function createPayload(): string
    {
        return json_encode(['query' => (string) (new RootType('query'))->addSubType((new Type('viewer'))->addSubType('login'))]);
    }
}
