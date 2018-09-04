<?php
declare(strict_types=1);

namespace GhRelease\Connection\Request;

use GraphQL\RequestBuilder\Argument;
use GraphQL\RequestBuilder\Type;
use GuzzleHttp\Psr7\Request;

/**
 * @author  david.pauli
 * @package GhRelease\Connection\Request
 * @since   17.08.2018
 */
class LastReleaseRequest extends Request
{
    private const METHOD = 'POST';
    private const URI = 'https://api.github.com/graphql';
    private const HEADERS = ['Content-Type' => 'application/json'];

    /**
     * @param string $owner Owner of the repository.
     * @param string $name  Name of the repository.
     */
    public function __construct(string $owner, string $name)
    {
        parent::__construct(self::METHOD, self::URI, self::HEADERS, $this->createPayload($owner, $name));
    }

    /**
     * Creates the payload to get last release information.
     *
     * @param  string $owner The owner of the repository.
     * @param  string $name  The name of the repository.
     * @return string
     */
    private function createPayload(string $owner, string $name): string
    {
        return json_encode([
            'query' => (string) (new Type('query'))
            ->addSubType((new Type('repository'))
                ->addArguments([
                    new Argument('name', $name),
                    new Argument('owner', $owner)
                ])
                ->addSubType((new Type('releases'))
                    ->addArgument(new Argument('last', 1))
                    ->addSubType((new Type('nodes'))
                        ->addSubType((new Type('tag'))
                            ->addSubType(new Type('name'))))))
        ]);
    }
}
