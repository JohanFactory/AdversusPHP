<?php

namespace AdversusPHP;

class Adversus
{
    /** @var Client */
    protected $client;

    public function __construct(string $username, string $password)
    {
        $this->client = new Client($username, $password);
        Model::init($this->client);
    }

    public function getCampaigns()
    {
        return Campaign::all();
    }

    public function getCampaign($id)
    {
        return Campaign::find($id);
    }
}
