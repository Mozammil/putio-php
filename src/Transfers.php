<?php
namespace Mozammil\Putio;

use Mozammil\Putio\Http\Client;

class Transfers
{
    /**
     * The Http Client
     *
     * @var Mozammil\Putio\Http\Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Lists active transfers.
     * If transfer is completed, it is removed from the list.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/transfers.html#get--transfers-list
     *
     * @return mixed
     */
    public function list()
    {
        return $this->client->get('transfers/list');
    }

    /**
     * Adds a new transfer.
     *
     * @param string $url
     * @param integer $save_parent_id
     * @param string $callback_url
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/transfers.html#post--transfers-add
     *
     * @return mixed
     */
    public function add(string $url, int $save_parent_id = 0, string $callback_url = null)
    {
        return $this->client->post('transfers/add', [
            'form_params' => [
                'url' => $url,
                'save_parent_id' => $save_parent_id,
                'callback_url' => $callback_url ? : ''
            ],
        ]);
    }

    /**
     * Returns a transfer’s properties.
     *
     * @param integer $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/transfers.html#get--transfers--id-
     *
     * @return mixed
     */
    public function get(int $id)
    {
        return $this->client->get(sprintf('transfers/%d', $id));
    }

    /**
     * Retry previously failed transfer.
     *
     * @param integer $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/transfers.html#retry
     *
     * @return mixed
     */
    public function retry(int $id)
    {
        return $this->client->post('transfers/retry', [
            'form_params' => ['id' => $id],
        ]);
    }

    /**
     * Deletes the given transfers.
     *
     * @param array $transfer_ids
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/transfers.html#cancel
     *
     * @return mixed
     */
    public function cancel(array $transfer_ids = [])
    {
        return $this->client->post('transfers/cancel', [
            'form_params' => ['transfer_ids' => implode(',', $transfer_ids)],
        ]);
    }

    /**
     * Clean completed transfers from the list.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/transfers.html#clean
     *
     * @return mixed
     */
    public function clean()
    {
        return $this->client->post('transfers/clean');
    }
}
