<?php

namespace Mozammil\Putio\Test;

use Mozammil\Putio\Http\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private $http;

    public function setUp()
    {
        $this->http = new Client('token');
    }

    public function test_it_can_make_a_get_request()
    {
        $response = $this->http->get('https://httpbin.org/user-agent');

        $this->assertRegexp('/Guzzle/', json_decode($response)->{'user-agent'});
    }

    public function test_it_can_make_a_post_request()
    {
        $response = $this->http->post('https://httpbin.org/anything', [
            'form_params' => [
                'foo' => 'baz',
            ],
        ]);

        $data = json_decode($response, true);

        $this->assertArrayHasKey('foo', $data['form']);
    }
}
