<?php
namespace Mozammil\Putio;

use Mozammil\Putio\Http\Client;

class Zips
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
     * Creates zip file for given files.
     * A zip_id is returned to keep track
     * of the status of zip creation process.
     *
     * @param array $file_ids
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/zips.html#post--zips-create
     *
     * @return mixed
     */
    public function create(array $file_ids = [])
    {
        return $this->client->post('zips/create', [
            'form_params' => [
                'file_ids' => implode(',', $file_ids)
            ]
        ]);
    }

    /**
     * Lists active zip files.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/zips.html#get--zips-list
     *
     * @return mixed
     */
    public function list()
    {
        return $this->client->get('zips/list');
    }

    /**
     * Gives detailed information about the give zip file id.
     * Check the zip creation process status with your zip_id.
     * When the process is done, you will get url value along
     * with size and missing_files.
     * You might need to poll this end point
     * until you get an url value.
     * missing_files is an array of file names
     * which are not included into the zip file for some reason.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/zips.html#get-zip
     *
     * @return mixed
     */
    public function get(int $zip_id)
    {
        return $this->client->get(sprintf('zips/%d', $zip_id));
    }
}
