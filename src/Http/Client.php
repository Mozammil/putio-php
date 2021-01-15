<?php

namespace Mozammil\Putio\Http;

use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\RequestInterface;

class Client
{
    /**
     * The API's base URI.
     */
    const URL = 'https://api.put.io/';

    /**
     * The API's version.
     */
    const VERSION = 'v2';

    /**
     * The HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Construct the HTTP client and passing the
     * token for authorization.
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->http = $this->http ?: $this->getHttpClient($token);
    }

    /**
     * Sends a GET Request.
     *
     * @param string $uri
     * @param array $query
     * @param array $options
     *
     * @return string JSON
     */
    public function get(string $uri, array $query = [], array $options = [])
    {
        $uri = $uri . ($query !== [] ? '?'.http_build_query($query) : '');
        $response = $this->http->request('GET', $uri, $options);

        return (string) $response->getBody()->getContents();
    }

    /**
     * Sends a POST Request.
     *
     * @param string $uri
     * @param array $options
     *
     * @return string JSON
     */
    public function post(string $uri, array $options = [])
    {
        $response = $this->http->request('POST', $uri, $options);

        return (string) $response->getBody()->getContents();
    }

    /**
     * Constructs the HTTP client.
     *
     * @param string $token
     *
     * @return \GuzzleHttp\Client
     */
    private function getHttpClient(string $token)
    {
        $stack = $this->getHandlerStack($token);

        return new GuzzleClient([
            'base_uri' => self::URL.self::VERSION.'/',
            'handler' => $stack,
        ]);
    }

    /**
     * Creates Guzzle Handler stack
     * Also appends the Oauth Token to every request.
     *
     * @param string $token
     *
     * @return \GuzzleHttp\HandlerStack $stack
     */
    private function getHandlerStack(string $token)
    {
        $stack = HandlerStack::create(new CurlHandler());

        $stack->push(Middleware::mapRequest(function (RequestInterface $request) use ($token) {
            return ! $this->containsAccessToken($request)
                ? $request->withUri(Uri::withQueryValue($request->getUri(), 'oauth_token', $token))
                : $request;
        }));

        return $stack;
    }

    /**
     * Checks if the request already contains an oauth_token.
     *
     * @param \Psr\Http\Message\RequestInterface $request
     *
     * @return bool
     */
    private function containsAccessToken(RequestInterface $request)
    {
        if (strpos($request->getUri()->getQuery(), 'oauth_token') !== false) {
            return true;
        }

        return false;
    }
}
