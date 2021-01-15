<?php

namespace Mozammil\Putio\Endpoints;

use Mozammil\Putio\Http\Client;
use Mozammil\Putio\Exceptions\FileNotFoundException;

class Files
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
     * Get a list of files/folders within a parent folder.
     *
     * @param  int $parent_id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#list
     *
     * @return string
     */
    public function list(int $parent_id = 0)
    {
        return $this->client->get('files/list', compact('parent_id'));
    }

    /**
     * Searches for a list of files/folders matching the keyword,
     * path, type and extension.
     *
     * @param string $keyword
     * @param array $from
     * @param array $type
     * @param array $ext
     * @param int $page
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#search
     *
     * @return string
     */
    public function search(string $keyword, array $from = [], array $type = [], array $ext = [], int $page = 1)
    {
        return $this->client->get(
            sprintf('files/search/%s/page/%d', $this->buildSearchQuery($keyword, $from, $type, $ext), $page)
        );
    }

    /**
     * Uploads a file.
     *
     * @param string $file
     * @param string $filename
     * @param int $parent_id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#upload
     *
     * @return string
     */
    public function upload(string $file, string $filename = null, int $parent_id = 0)
    {
        if (! realpath($file)) {
            throw new FileNotFoundException("File {$file} could not be found");
        }

        $uri = sprintf('https://upload.put.io/%s/files/upload?parent_id=%d', $this->client::VERSION, $parent_id);

        return $this->client->post($uri, [
            'multipart' => [
                [
                    'name' => 'file',
                    'filename' => $filename ?: basename($file),
                    'contents' => realpath($file),
                ],
            ],
        ]);
    }

    /**
     * Creates a folder.
     *
     * @param string $name
     * @param int $parent_id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#create-folder
     *
     * @return string
     */
    public function createFolder(string $name, int $parent_id = 0)
    {
        return $this->client->post('files/create-folder', [
            'form_params' => compact('name', 'parent_id'),
        ]);
    }

    /**
     * Returns a file’s properties.
     *
     * @param int $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#get
     *
     * @return string
     */
    public function get(int $id)
    {
        return $this->client->get(sprintf('files/%s', $id));
    }

    /**
     * Deletes a list of files/folders with the specified ids.
     *
     * @param  array $file_ids
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#delete
     *
     * @return string
     */
    public function delete(array $file_ids = [])
    {
        $file_ids = implode(',', $file_ids);

        return $this->client->post('files/delete', [
            'form_params' => compact('file_ids'),
        ]);
    }

    /**
     * Renames given file/folder.
     *
     * @param int $file_id
     * @param string $name
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#rename
     *
     * @return string
     */
    public function rename(int $file_id, string $name)
    {
        return $this->client->post('files/rename', [
            'form_params' => compact('file_id', 'name'),
        ]);
    }

    /**
     * Moves given file/folder.
     *
     * @param array $file_ids
     * @param int $parent_id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#move
     *
     * @return string
     */
    public function move(array $file_ids = [], int $parent_id = 0)
    {
        $file_ids = implode(',', $file_ids);

        return $this->client->post('files/move', [
            'form_params' => compact('file_ids', 'parent_id'),
        ]);
    }

    /**
     * Converts given file to mp4.
     *
     * @param int $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#convert-to-mp4
     *
     * @return string
     */
    public function convertToMp4(int $id)
    {
        return $this->client->post(sprintf('files/%d/mp4', $id));
    }

    /**
     * Returns the status of mp4 conversion of the given file.
     *
     * @param int $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#get-mp4-status
     *
     * @return string
     */
    public function getMp4Status(int $id)
    {
        return $this->client->get(sprintf('files/%d/mp4', $id));
    }

    /**
     * Donwloads a file from put.io locally.
     *
     * @param int $id
     * @param string $path
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#download
     *
     * @return string
     */
    public function download(int $id, string $path, string $filename = null)
    {
        if (! $filename) {
            $response = $this->get($id);
            $filename = json_decode($response, true)['file']['name'];
        }

        $response = $this->client->get(sprintf('files/%d/url', $id));
        $download = json_decode($response, true)['url'];

        if (! $download) {
            throw new FileNotFoundException('This file could not be found on the server');
        }
       
        return $this->client->get($download, [], [
            'sink' => "{$path}/{$filename}",
            'allow_redirects' => false,
        ]);
    }

    /**
     * Share given files with friends.
     *
     * @param array $file_ids
     * @param array $friends
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#sharing
     *
     * @return string
     */
    public function share(array $file_ids = [], array $friends = [])
    {
        return $this->client->post('files/share', [
            'form_params' => [
                'file_ids' => implode(',', $file_ids),
                'friends' => implode(',', $friends),
            ],
        ]);
    }

    /**
     * Returns list of shared files and share information.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#get--files-shared
     *
     * @return string
     */
    public function shared()
    {
        return $this->client->get('files/shared');
    }

    /**
     * Returns list of users file is shared with.
     * Each result item contains a share id which can be used for unsharing.
     *
     * @param int $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#get--files--id--shared-with
     *
     * @return string
     */
    public function sharedWith(int $id)
    {
        return $this->client->get(sprintf('files/%d/shared-with', $id));
    }

    /**
     * Unshares given file from given friends or from everyone.
     *
     * @param int $id
     * @param array $friends
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#post--files--id--unshare
     *
     * @return string
     */
    public function unshare(int $id, array $friends = [])
    {
        return $this->client->post(sprintf('files/%d/unshare', $id), [
            'form_params' => [
                'shares' => count($friends) ? implode(',', $friends) : 'everyone',
            ],
        ]);
    }

    /**
     * Lists available subtitles for user’s preferred language.
     * User must select “Default Subtitle Language” from settings page.
     *
     * @param int $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#subtitles
     *
     * @return string
     */
    public function subtitles(int $id)
    {
        return $this->client->get(sprintf('files/%d/subtitles', $id));
    }

    /**
     * Downloads a subtitle.
     *
     * @param int $id
     * @param string $format
     * @param string $path
     * @param string $filename
     * @param string $key
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#download-subtitle
     *
     * @return string
     */
    public function downloadSubtitle(
        int $id,
        string $format,
        string $path,
        string $filename = null,
        string $key = 'default'
    ) {
        if (! $filename) {
            $response = $this->get($id);
            $filename = pathinfo(json_decode($response, true)['file']['name'], PATHINFO_FILENAME).".{$format}";
        }

        return $this->client->get(
            sprintf('files/%d/subtitles/%s', $id, $key),
            ['format' => $format],
            [
                'sink' => "{$path}/{$filename}",
                'allow_redirects' => false,
            ]
        );
    }

    /**
     * Serves a HLS playlist for a video file.
     *
     * @param int $id
     * @param string $path
     * @param string $filename
     * @param string $subtitle_key
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#hls-playlist
     *
     * @return string
     */
    public function hlsPlaylist(int $id, string $path, string $filename = null, string $subtitle_key = 'all')
    {
        if (! $filename) {
            $response = $this->get($id);
            $filename = pathinfo(json_decode($response, true)['file']['name'], PATHINFO_FILENAME);
        }

        return $this->client->get(
            sprintf('files/%d/hls/media.m3u8', $id),
            ['subtitle_key' => $subtitle_key],
            [
                'sink' => "{$path}/{$filename}.m3u8",
                'allow_redirects' => false,
            ]
        );
    }

    /**
     * List of dashboard events. Includes download and share events.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#get--events-list
     *
     * @return string
     */
    public function events()
    {
        return $this->client->get('events/list');
    }

    /**
     * Clear all dashboard events.
     * User’s home screen (dashboard) which uses same data will also be cleared at Put.io website.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#post--events-delete
     *
     * @return string
     */
    public function deleteEvents()
    {
        return $this->client->post('events/delete');
    }

    /**
     * Sets default video position for a video file.
     *
     * @param int $id
     * @param int $time in seconds
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#set-video-position
     *
     * @return string
     */
    public function setVideoPosition(int $id, int $time)
    {
        return $this->client->post(sprintf('files/%d/start-from', $id), [
            'form_params' => compact('time'),
        ]);
    }

    /**
     * Delete video position for a video file.
     *
     * @param int $id
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @see https://api.put.io/v2/docs/files.html#delete-video-position
     *
     * @return string
     */
    public function deleteVideoPosition(int $id)
    {
        return $this->client->post(sprintf('files/%d/start-from/delete', $id));
    }

    /**
     * Builds a search query.
     *
     * @param string $keyword
     * @param array $from
     * @param array $type
     * @param array $ext
     *
     * @see https://api.put.io/v2/docs/files.html#search
     *
     * @return string
     */
    private function buildSearchQuery(string $keyword, array $from = [], array $type = [], array $ext = [])
    {
        $query = '/'.rawurlencode($keyword);

        if (count($from)) {
            $query .= ' from: "'.implode(',', $from).'"';
        }

        if (count($type)) {
            $query .= ' type:'.implode(',', $type);
        }

        if (count($ext)) {
            $query .= ' ext:'.implode(',', $ext);
        }

        return $query;
    }
}
