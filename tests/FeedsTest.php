<?php

namespace Mozammil\Putio\Test;

use PHPUnit\Framework\TestCase;
use Mozammil\Putio\Endpoints\Feeds;

class FeedsTest extends TestCase
{
    public function test_feeds_create()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('create');

        $feeds = new Feeds($stub);
        $this->assertEquals('create', $feeds->create('Foo', 'http://foo.baz'));
    }

    public function test_feeds_list()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('list');

        $feeds = new Feeds($stub);
        $this->assertEquals('list', $feeds->list());
    }

    public function test_feeds_get()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('get');

        $feeds = new Feeds($stub);
        $this->assertEquals('get', $feeds->get(1));
    }

    public function test_feeds_update()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('update');

        $feeds = new Feeds($stub);
        $this->assertEquals('update', $feeds->update(1, 'Foo', 'http://foo.baz'));
    }

    public function test_feeds_pause()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('pause');

        $feeds = new Feeds($stub);
        $this->assertEquals('pause', $feeds->pause(1));
    }

    public function test_feeds_resume()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('resume');

        $feeds = new Feeds($stub);
        $this->assertEquals('resume', $feeds->resume(1));
    }

    public function test_feeds_delete()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('delete');

        $feeds = new Feeds($stub);
        $this->assertEquals('delete', $feeds->delete(1));
    }
}
