<?php

namespace Mozammil\Putio;

use Mozammil\Putio\Http\Client;

class Feeds
{
    /**
     * The Http Client.
     *
     * @var \Mozammil\Putio\Http\Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Creates an RSS feed with the given parameters.
     *
     * @param string $title Title of the RSS feed as will appear on the site
     * @param string $rss_source_url The URL of the RSS feed to be watched
     * @param int $parent_dir_id The file ID of the folder to place the RSS feed files in
     * @param bool $delete_old_files Should old files in the folder be deleted when space is low
     * @param bool $dont_process_whole_feed Should the current items in the feed, at creation time, be ignored
     * @param array $keywords Only items with titles that contain any of these words will be transferred
     * @param array $unwanted_keywords No items with titles that contain any of these words will be transferred
     * @param bool $paused Should the RSS feed be created in the paused state
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/feeds.html#post--rss-create
     *
     * @return string
     */
    public function create(
        string $title,
        string $rss_source_url,
        int $parent_dir_id = 0,
        bool $delete_old_files = false,
        bool $dont_process_whole_feed = false,
        array $keywords = [],
        array $unwanted_keywords = [],
        bool $paused = false
    ) {
        return $this->client->post('rss/create', [
            'form_params' => [
                'title' => $title,
                'rss_source_url' => $rss_source_url,
                'parent_dir_id' => $parent_dir_id,
                'delete_old_files' => $delete_old_files,
                'dont_process_whole_feed' => $dont_process_whole_feed,
                'keywords' => count($keywords) ? implode(',', $keywords) : null,
                'unwanted_keywords' => count($unwanted_keywords) ? implode(',', $unwanted_keywords) : null,
                'paused' => $paused,
            ],
        ]);
    }

    /**
     * Lists RSS feeds.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/feeds.html#get--rss-list
     *
     * @return string
     */
    public function list()
    {
        return $this->client->get('rss/list');
    }

    /**
     * Gives detailed information about the given feed id.
     *
     * @param int $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/feeds.html#get--rss-list
     *
     * @return string
     */
    public function get(int $id)
    {
        return $this->client->get(sprintf('rss/%d', $id));
    }

    /**
     * Updates an RSS feed with the given parameters.
     *
     * @param int $id Id of the RSS feed to be updated
     * @param string $title Title of the RSS feed as will appear on the site
     * @param string $rss_source_url The URL of the RSS feed to be watched
     * @param int $parent_dir_id The file ID of the folder to place the RSS feed files in
     * @param bool $delete_old_files Should old files in the folder be deleted when space is low
     * @param bool $dont_process_whole_feed Should the current items in the feed, at creation time, be ignored
     * @param array $keywords Only items with titles that contain any of these words will be transferred
     * @param array $unwanted_keywords No items with titles that contain any of these words will be transferred
     * @param bool $paused Should the RSS feed be created in the paused state
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/feeds.html#update
     *
     * @return string
     */
    public function update(
        int $id,
        string $title,
        string $rss_source_url,
        int $parent_dir_id = 0,
        bool $delete_old_files = false,
        bool $dont_process_whole_feed = false,
        array $keywords = [],
        array $unwanted_keywords = [],
        bool $paused = false
    ) {
        return $this->client->post(sprintf('rss/%d', $id), [
            'form_params' => [
                'title' => $title,
                'rss_source_url' => $rss_source_url,
                'parent_dir_id' => $parent_dir_id,
                'delete_old_files' => $delete_old_files,
                'dont_process_whole_feed' => $dont_process_whole_feed,
                'keywords' => count($keywords) ? implode(',', $keywords) : null,
                'unwanted_keywords' => count($unwanted_keywords) ? implode(',', $unwanted_keywords) : null,
                'paused' => $paused,
            ],
        ]);
    }

    /**
     * Pauses the RSS feed, so that it is not polled for new items anymore.
     *
     * @param int $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/feeds.html#post--rss--feed_id--pause
     *
     * @return string
     */
    public function pause(int $id)
    {
        return $this->client->post(sprintf('rss/%d/pause', $id));
    }

    /**
     * Resumes the RSS feed, so that it starts being polled for new items again.
     *
     * @param int $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/feeds.html#post--rss--feed_id--resume
     *
     * @return string
     */
    public function resume(int $id)
    {
        return $this->client->post(sprintf('rss/%d/resume', $id));
    }

    /**
     * Deletes given RSS feed.
     *
     * @param int $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/feeds.html#post--rss--feed_id--delete
     *
     * @return string
     */
    public function delete(int $id)
    {
        return $this->client->post(sprintf('rss/%d/delete', $id));
    }
}
