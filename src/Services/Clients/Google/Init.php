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
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));
        $this->client->setRedirectUri('postmessage');
        $this->client->setAccessToken($token);
    }

    public function isTokenExpired(): bool
    {

        return $this->client->isAccessTokenExpired();
    }

    public function refreshToken($refreshToken): void
    {
        $this->client->fetchAccessTokenWithRefreshToken($refreshToken);
    }
}