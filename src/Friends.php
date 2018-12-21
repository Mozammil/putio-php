<?php
namespace Mozammil\Putio;

use Mozammil\Putio\Http\Client;

class Friends
{
    /**
     * The Http Client
     *
     * @var \Mozammil\Putio\Http\Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Lists friends.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/friends.html#get--friends-list
     *
     * @return mixed
     */
    public function list()
    {
        return $this->client->get('friends/list');
    }

    /**
     * Lists incoming friend requests.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/friends.html#get--friends-waiting-requests
     *
     * @return mixed
     */
    public function requests()
    {
        return $this->client->get('friends/waiting-requests');
    }

    /**
     * Sends a friend request to the given username.
     *
     * @param string $username
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/friends.html#send-request
     *
     * @return mixed
     */
    public function sendRequest(string $username)
    {
        return $this->client->post(sprintf('friends/%s/request', $username));
    }

    /**
     * Approves a friend request from the given username.
     *
     * @param string $username
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/friends.html#approve
     *
     * @return mixed
     */
    public function approveRequest(string $username)
    {
        return $this->client->post(sprintf('friends/%s/approve', $username));
    }

    /**
     * Denies a friend request from the given username.
     *
     * @param string $username
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/friends.html#post--friends--username--deny
     *
     * @return mixed
     */
    public function denyRequest(string $username)
    {
        return $this->client->post(sprintf('friends/%s/deny', $username));
    }

    /**
     * Removes friend from friend list.
     * Files shared with all friends will be automatically
     * removed from old friend’s directory.
     *
     * @param string $username
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/friends.html#unfriend
     *
     * @return mixed
     */
    public function unfriend(string $username)
    {
        return $this->client->post(sprintf('friends/%s/unfriend', $username));
    }
}
