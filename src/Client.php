<?php

namespace AdversusPHP;

/**
 * Class Client
 *
 * @package AdversusPHP
 */
class Client extends \GuzzleHttp\Client
{

    /**
     * Client constructor.
     *
     * @param array $username
     * @param       $password
     */
    public function __construct($username, $password)
    {
        parent::__construct([
            'base_uri' => 'https://api.adversus.dk/v1',
            'auth'     => [$username, $password],
            'headers'  => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }
}