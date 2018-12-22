<?php

namespace Mozammil\Putio;

use Mozammil\Putio\Http\Client;
use Mozammil\Putio\Endpoints\Zips;
use Mozammil\Putio\Endpoints\Feeds;
use Mozammil\Putio\Endpoints\Files;
use Mozammil\Putio\Endpoints\Account;
use Mozammil\Putio\Endpoints\Friends;
use Mozammil\Putio\Endpoints\Transfers;

class Putio
{
    /**
     * The Http client.
     *
     * @var \Mozammil\Putio\Http\Client
     */
    protected $client;

    /**
     * Initialises the HTTP client.
     *
     * @param string $token
     *
     * @return void
     */
    public function __construct(string $token)
    {
        $this->client = $this->client ?: new Client($token);
    }

    /**
     * Files instance.
     *
     * @return \Mozammil\Putio\Endpoints\Files
     */
    public function files()
    {
        return new Files($this->client);
    }

    /**
     * Transfers instance.
     *
     * @return \Mozammil\Putio\Endpoints\Transfers
     */
    public function transfers()
    {
        return new Transfers($this->client);
    }

    /**
     * Zips instance.
     *
     * @return \Mozammil\Putio\Endpoints\Zips
     */
    public function zips()
    {
        return new Zips($this->client);
    }

    /**
     * Feeds instance.
     *
     * @return \Mozammil\Putio\Endpoints\Feeds
     */
    public function feeds()
    {
        return new Feeds($this->client);
    }

    /**
     * Friends instance.
     *
     * @return \Mozammil\Putio\Endpoints\Friends
     */
    public function friends()
    {
        return new Friends($this->client);
    }

    /**
     * Account instance.
     *
     * @return \Mozammil\Putio\Endpoints\Account
     */
    public function account()
    {
        return new Account($this->client);
    }
}
