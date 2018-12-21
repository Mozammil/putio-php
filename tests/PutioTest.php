<?php
namespace Mozammil\Putio\Test;

use Mozammil\Putio\Putio;
use Mozammil\Putio\Files;
use Mozammil\Putio\Transfers;
use Mozammil\Putio\Zips;
use Mozammil\Putio\Feeds;
use Mozammil\Putio\Friends;
use Mozammil\Putio\Account;
use PHPUnit\Framework\TestCase;

class PutioTest extends TestCase
{
    public function test_files_instance()
    {
        $putio = new Putio('token');

        $this->assertInstanceOf(Files::class, $putio->files());
    }

    public function test_transfers_instance()
    {
        $putio = new Putio('token');

        $this->assertInstanceOf(Transfers::class, $putio->transfers());
    }

    public function test_zips_instance()
    {
        $putio = new Putio('token');

        $this->assertInstanceOf(Zips::class, $putio->zips());
    }

    public function test_feeds_instance()
    {
        $putio = new Putio('token');

        $this->assertInstanceOf(Feeds::class, $putio->feeds());
    }

    public function test_friends_instance()
    {
        $putio = new Putio('token');

        $this->assertInstanceOf(Friends::class, $putio->friends());
    }

    public function test_acccount_instance()
    {
        $putio = new Putio('token');

        $this->assertInstanceOf(Account::class, $putio->account());
    }
}
