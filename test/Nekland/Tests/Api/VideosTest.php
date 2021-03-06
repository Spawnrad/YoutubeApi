<?php

/**
 * This file is a part of nekland youtube api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\Tests\Api;


use Nekland\YoutubeApi\Youtube;

class VideosTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldReturnYoutubeArrayAsJson()
    {
        $youtube = $this->getYoutubeMock(['get' => $this->getYoutubeList()]);
        /** @var \Nekland\YoutubeApi\Api\Videos $videos */
        $videos  = $youtube->api('videos');

        $this->assertEquals($videos->listById('DR7e0DoHZ2Y')['etag'], '"X98aQHqGvPBJLZLOiSGUHCM9jnE/DqrNg5r4X93fnTIO0si3XjQXUwY"');
        $this->assertEquals($videos->getById('DR7e0DoHZ2Y')['id'], 'DR7e0DoHZ2Y');
        $this->assertEquals($videos->listBy(['id' => 'DR7e0DoHZ2Y'])['etag'], '"X98aQHqGvPBJLZLOiSGUHCM9jnE/DqrNg5r4X93fnTIO0si3XjQXUwY"');
    }

    private function getYoutubeList()
    {
        return '
{
 "kind": "youtube#videoListResponse",
 "etag": "\\"X98aQHqGvPBJLZLOiSGUHCM9jnE/DqrNg5r4X93fnTIO0si3XjQXUwY\\"",
 "pageInfo": {
  "totalResults": 1,
  "resultsPerPage": 1
 },
 "items": [
  {
   "kind": "youtube#video",
   "etag": "\\"X98aQHqGvPBJLZLOiSGUHCM9jnE/PYBJAtNy79ShJyHHToh-N89kDH4\\"",
   "id": "DR7e0DoHZ2Y",
   "snippet": {
    "publishedAt": "2014-02-19T18:00:04.000Z",
    "channelId": "UCvOGElQWhX8tyTxwzv1rKzg",
    "title": "Mystery Skulls - Ghost (Solidisco Remix)\u200f",
    "description": "ENM ● New Songs every Monday, Wednesday & Friday!\nDownload it from iTunes: http://bit.ly/1e5u2pM\n\nBecome a fan of Solidisco\nFB: https://facebook.com/solidisco\nSoundcloud: http://soundcloud.com/solidisco\n\nBecome a fan of Mystery Skulls\nFB: https://facebook.com/mysteryskulls\nSoundcloud: http://soundcloud.com/mysteryskulls\n\nFollow Warner bros. Records\nFB: http://facebook.com/WarnerBrosRecords\nYouTube: http://youtube.com/warnerbrosrecords\nhttp://warnerbrosrecords.com\n\nOriginal artwork: http://bit.ly/1bK1bge\n------------------------------------------------------------\nStay connected with us\nFB: http://on.fb.me/tWNN6B\n@epicnetwork\nGoogle+ http://google.com/+EpicNetworkMusic\nSoundcloud: http://snd.sc/1hQlDce\n------------------------------------------------------------\nTrack\'s title: Mystery Skulls - Ghost (Solidisco Remix)\u200f",
    "thumbnails": {
     "default": {
      "url": "https://i1.ytimg.com/vi/DR7e0DoHZ2Y/default.jpg"
     },
     "medium": {
      "url": "https://i1.ytimg.com/vi/DR7e0DoHZ2Y/mqdefault.jpg"
     },
     "high": {
      "url": "https://i1.ytimg.com/vi/DR7e0DoHZ2Y/hqdefault.jpg"
     },
     "standard": {
      "url": "https://i1.ytimg.com/vi/DR7e0DoHZ2Y/sddefault.jpg"
     }
    },
    "channelTitle": "ENM",
    "categoryId": "10",
    "liveBroadcastContent": "none"
   }
  }
 ]
}';
    }

    /**
     * @param array $data an array of method => return for the httpclient mocked
     * @return Youtube
     */
    private function getYoutubeMock(array $data)
    {
        $httpClient = $this->getMock('Nekland\\BaseApi\\Http\\ClientInterface');

        foreach($data as $method => $return) {
            $httpClient->expects($this->any())
                ->method($method)
                ->willReturn($return)
            ;
        }

        return new Youtube($httpClient);
    }
}
