<?php

namespace Mozammil\Putio\Test;

use Mozammil\Putio\Endpoints\Friends;
use PHPUnit\Framework\TestCase;

class FriendsTest extends TestCase
{
    public function test_friends_list()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('list');

        $friends = new Friends($stub);
        $this->assertEquals('list', $friends->list());
    }

    public function test_friends_requests()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('requests');

        $friends = new Friends($stub);
        $this->assertEquals('requests', $friends->requests());
    }

    public function test_friends_send_request()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('send_request');

        $friends = new Friends($stub);
        $this->assertEquals('send_request', $friends->sendRequest('Foo'));
    }

    public function test_friends_approve_request()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('approve_request');

        $friends = new Friends($stub);
        $this->assertEquals('approve_request', $friends->approveRequest('Foo'));
    }

    public function test_friends_deny_request()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('deny_request');

        $friends = new Friends($stub);
        $this->assertEquals('deny_request', $friends->denyRequest('Foo'));
    }

    public function test_friends_unfriend()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('unfriend');

        $friends = new Friends($stub);
        $this->assertEquals('unfriend', $friends->unfriend('Foo'));
    }
}
