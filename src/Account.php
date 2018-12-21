<?php
namespace Mozammil\Putio;

use Mozammil\Putio\Http\Client;

class Account
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
     * Information about user account.
     * subtitle_languages is a list of ISO639-2 codes.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/account.html#get--account-info
     *
     * @return string
     */
    public function info()
    {
        return $this->client->get('account/info');
    }

    /**
     * User preferences
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/account.html#get--account-settings
     *
     * @return string
     */
    public function settings()
    {
        return $this->client->get('account/settings');
    }

    /**
     * Updates user preferences. Only sent parameters are updated.
     *
     * @param integer $default_download_folder
     * @param boolean $is_invisible
     * @param array $subtitle_languages
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/account.html#post--account-settings
     *
     * @return string
     */
    public function update(
        int $default_download_folder = null,
        bool $is_invisible = null,
        array $subtitle_languages = []
    ) {
        $params = [];

        if($default_download_folder) {
            $params['default_download_folder'] = $default_download_folder;
        }

        if ($is_invisible) {
            $params['is_invisible'] = $is_invisible;
        }

        if (count($subtitle_languages)) {
            $params['subtitle_languages'] = implode(',', $subtitle_languages);
        }

        return $this->client->post('account/settings', [
            'form_params' => $params
        ]);
    }
}
