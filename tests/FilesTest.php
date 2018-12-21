<?php

namespace Mozammil\Putio\Test;

use Mozammil\Putio\Files;
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    public function test_files_list()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('list');

        $files = new Files($stub);
        $this->assertEquals('list', $files->list());
    }

    public function test_files_search()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('search');

        $files = new Files($stub);
        $this->assertEquals('search', $files->search('Foo'));
    }

    public function test_files_upload()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('upload');

        $files = new Files($stub);
        $this->assertEquals('upload', $files->upload(__DIR__.'/FilesTest.php'));
    }

    public function test_files_create_folder()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('create');

        $files = new Files($stub);
        $this->assertEquals('create', $files->createFolder('Foo'));
    }

    public function test_files_get()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('get');

        $files = new Files($stub);
        $this->assertEquals('get', $files->get(1234));
    }

    public function test_files_delete()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('delete');

        $files = new Files($stub);
        $this->assertEquals('delete', $files->delete([1, 2, 3, 4]));
    }

    public function test_files_rename()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('rename');

        $files = new Files($stub);
        $this->assertEquals('rename', $files->rename(1, 'Foo'));
    }

    public function test_files_move()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('move');

        $files = new Files($stub);
        $this->assertEquals('move', $files->move([1, 2, 3], 1));
    }

    public function test_files_convert_to_mp4()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('convertToMp4');

        $files = new Files($stub);
        $this->assertEquals('convertToMp4', $files->convertToMp4(1));
    }

    public function test_files_get_mp4_status()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('getMp4Status');

        $files = new Files($stub);
        $this->assertEquals('getMp4Status', $files->getMp4Status(1));
    }

    public function test_files_download()
    {
        $response = json_encode([
            'url' => 'Bar',
        ]);

        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn($response);

        $files = new Files($stub);
        $this->assertEquals($response, $files->download(1, __DIR__.'/Data', 'Video.mp4'));
    }

    public function test_files_share()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('share');

        $files = new Files($stub);
        $this->assertEquals('share', $files->share([1, 2, 3], ['Foo', 'Bar', 'Baz']));
    }

    public function test_files_shared()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('shared');

        $files = new Files($stub);
        $this->assertEquals('shared', $files->shared());
    }

    public function test_files_shared_with()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('shared_with');

        $files = new Files($stub);
        $this->assertEquals('shared_with', $files->sharedWith(1));
    }

    public function test_files_unshared()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('unshare');

        $files = new Files($stub);
        $this->assertEquals('unshare', $files->unshare(1, ['Foo', 'Bar', 'Baz']));
    }

    public function test_files_subtitles()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('subtitles');

        $files = new Files($stub);
        $this->assertEquals('subtitles', $files->subtitles(1));
    }

    public function test_files_download_subtitles()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('subtitles');

        $files = new Files($stub);
        $this->assertEquals('subtitles', $files->downloadSubtitle(1, 'srt', __DIR__.'/Data', 'Subtitle.srt'));
    }

    public function test_files_hls_playlist()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('hls_playlist');

        $files = new Files($stub);
        $this->assertEquals('hls_playlist', $files->hlsPlaylist(1, __DIR__.'/Data', 'media.m3u8'));
    }

    public function test_files_events()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('get')->willReturn('events');

        $files = new Files($stub);
        $this->assertEquals('events', $files->events());
    }

    public function test_files_delete_events()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('delete_events');

        $files = new Files($stub);
        $this->assertEquals('delete_events', $files->deleteEvents());
    }

    public function test_files_set_video_position()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('set_video_position');

        $files = new Files($stub);
        $this->assertEquals('set_video_position', $files->setVideoPosition(1, 60));
    }

    public function test_files_delete_video_position()
    {
        $stub = $this->getMockBuilder('Mozammil\Putio\Http\Client')->disableOriginalConstructor()->getMock();
        $stub->method('post')->willReturn('delete_video_position');

        $files = new Files($stub);
        $this->assertEquals('delete_video_position', $files->deleteVideoPosition(1));
    }
}
