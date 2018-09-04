<?php
declare(strict_types=1);

namespace GhReleaseTest\Connection;

use GhRelease\Connection\Client;
use GhRelease\Exception\NotConfiguredException;
use PHPUnit\Framework\TestCase;

/**
 * @author  david.pauli
 * @package GhReleaseTest\Connection
 * @since   21.08.2018
 */
class ClientTest extends TestCase
{
    private const RELEASE_OWNER = 'dpauli';
    private const RELEASE_NAME = 'php-graphql-request-builder';

    public function testNoConfiguration(): void
    {
        $client = new Client();
        $this->expectException(NotConfiguredException::class);

        $client->latestReleases(self::RELEASE_OWNER, self::RELEASE_NAME);
    }

    public function testLatestRelease(): void
    {
        $client = new Client();
        $client->configure();

        $latestVersion = $client->latestReleases(self::RELEASE_OWNER, self::RELEASE_NAME);

        static::assertNotNull($latestVersion, 'There is a latest version.');
    }
}
