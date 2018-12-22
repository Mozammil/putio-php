<?php

namespace Mozammil\Putio\Test;

use PHPUnit\Framework\TestCase;
use Mozammil\Putio\Endpoints\Account;

class AccountTest extends TestCase
{
    public function test_account_info()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('info');

        $account = new Account($stub);
        $this->assertEquals('info', $account->info());
    }

    public function test_account_settings()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('settings');

        $account = new Account($stub);
        $this->assertEquals('settings', $account->settings());
    }

    public function test_account_update()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('update');

        $account = new Account($stub);
        $this->assertEquals('update', $account->update(1, false, ['en', 'fr']));
    }
}
