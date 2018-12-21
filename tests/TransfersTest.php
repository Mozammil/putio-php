<?php

namespace Mozammil\Putio\Test;

use Mozammil\Putio\Transfers;
use PHPUnit\Framework\TestCase;

class TransfersTest extends TestCase
{
    public function test_transfers_list()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('list');

        $transfers = new Transfers($stub);
        $this->assertEquals('list', $transfers->list());
    }

    public function test_transfers_add()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('add');

        $transfers = new Transfers($stub);
        $this->assertEquals('add', $transfers->add('magnet:url'));
    }

    public function test_transfers_get()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('get');

        $transfers = new Transfers($stub);
        $this->assertEquals('get', $transfers->get(1));
    }

    public function test_transfers_retry()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('retry');

        $transfers = new Transfers($stub);
        $this->assertEquals('retry', $transfers->retry(1));
    }

    public function test_transfers_cancel()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('cancel');

        $transfers = new Transfers($stub);
        $this->assertEquals('cancel', $transfers->cancel([1, 2, 3]));
    }

    public function test_transfers_clean()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('clean');

        $transfers = new Transfers($stub);
        $this->assertEquals('clean', $transfers->clean());
    }
}
