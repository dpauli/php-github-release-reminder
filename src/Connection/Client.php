<?php
declare(strict_types=1);

namespace GhRelease\Connection;

/**
 * @author  david.pauli
 * @package GhRelease/Connection
 * @since   17.08.2018
 */
class Client
{
    private const BASE_URL = 'https://api.github.com/graphql';

    /** @var string */
    private $token;
}
