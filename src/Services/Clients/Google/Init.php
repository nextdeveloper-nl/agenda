<?php

namespace NextDeveloper\Agenda\Services\Clients\Google;



use Google\Client as GoogleClient;

class Init
{
    protected GoogleClient $client;

    public function __construct($token)
    {
        $token = decrypt($token);
        $this->client = new GoogleClient();
        $this->client->setAccessToken($token);
    }
}