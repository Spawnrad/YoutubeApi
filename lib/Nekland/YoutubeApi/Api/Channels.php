<?php

/**
 * This file is a part of nekland youtube api package
 *
 * (c) Nekland <nekland.fr@gmail.fr>
 *
 * For the full license, take a look to the LICENSE file
 * on the root directory of this project
 */

namespace Nekland\YoutubeApi\Api;

use Nekland\BaseApi\Api\AbstractApi;

/**
 * Class Videos
 *
 * @see https://developers.google.com/youtube/v3/docs/channels/list for more information about paramaters
 * @see https://developers.google.com/youtube/v3/docs/channels#resource for more information about json format
 *
 * @package Nekland\YoutubeApi\Api
 */
class Channels extends AbstractApi
{

    const URL = 'youtube/v3/channels';

    public function listByName($username, array $parts = ['snippet'], array $otherParameters = [])
    {

        $parameters = array_merge(
            ['part' => implode(',', $parts), 'forUsername' => $username], $otherParameters
        );

        return $this->get(self::URL, $parameters);
    }

    public function listById($channelid, array $parts = ['snippet'], array $otherParameters = [])
    {

        $parameters = array_merge(
            ['part' => implode(',', $parts), 'id' => $channelid, 'key' => 'AIzaSyBHqlUjoOxmZhg3SXwWzqxBEIpX_G_QjlU'], $otherParameters
        );

        return $this->get(self::URL, $parameters);
    }

    public function getUploadIdByName($username, array $parts = ['snippet'], array $otherParameters = [])
    {

        return $this->listByName($username, $parts, $otherParameters)['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
    }

    public function getUploadIdById($channelid, array $parts = ['snippet'], array $otherParameters = [])
    {

        return $this->listById($channelid, $parts, $otherParameters)['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
    }

    public function getUploadIdFromUrl($url, array $parts = ['snippet'], array $otherParameters = [])
    {

        return $this->getChannelFromURL($url, $parts, $otherParameters)['items'][0]['contentDetails']['relatedPlaylists']['uploads'];
    }


    /**
     * Get the channel object by supplying the URL of the channel page
     *
     *
     * @param type $youtube_url
     * @param array $parts
     * @param array $otherParameters
     * @return type
     * @throws \Exception
     */
    public function getChannelFromURL($youtube_url, array $parts = ['snippet'], array $otherParameters = [])
    {
        if (strpos($youtube_url, 'youtube.com') === false) {
            throw new \Exception('The supplied URL does not look like a Youtube URL');
        }

        $path = self::_parse_url_path($youtube_url);
        if (strpos($path, '/channel') === 0) {
            $segments = explode('/', $path);
            $channelId = $segments[count($segments) - 1];
            $channel = $this->listById($channelId, $parts, $otherParameters);
        } else if (strpos($path, '/user') === 0) {
            $segments = explode('/', $path);
            $username = $segments[count($segments) - 1];
            $channel = $this->listByName($username, $parts, $otherParameters);
        } else {
            throw new \Exception('The supplied URL does not look like a Youtube Channel URL');
        }

        return $channel;
    }

    /**
     * Parse the input url string and return just the path part
     *
     * @param  string $url the URL
     * @return string      the path string
     */
    public static function _parse_url_path($url)
    {
        $array = parse_url($url);
        return $array['path'];
    }

}
