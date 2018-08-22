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
    public function testNoConfiguration(): void
    {
        $client = new Client();
        $this->expectException(NotConfiguredException::class);

        $client->authorize();
    }

    public function testAuthenticate(): void
    {
        $client = new Client();
        $client->configure();

        $client->authorize();
    }
}
