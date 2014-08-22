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
class PlaylistItems extends AbstractApi
{

    const URL = 'youtube/v3/playlistItems';

    /**
     * @param $playlistId
     *
     * @param type $playlistId
     * @param array $parts
     * @param array $otherParameters
     * @return type
     */
    public function listByPlaylistId($playlistId, array $parts = ['snippet'], array $otherParameters = [], array $headers = [])
    {

        $parameters = array_merge(
            ['part' => implode(',', $parts), 'playlistId' => $playlistId], $otherParameters
        );

        return $this->get(self::URL, $parameters, $headers);
    }

    /*
     * Get Video Items By Id
     */
    public function getItems($list)
    {

        return $list['items'];
    }

    /*
     * Get PlaylistItem Etag
     */
    public function getEtag($list)
    {
        return $list['etag'];
    }

    /*
     * Get Video Title
     */
    public function getTitle($item)
    {

        return $item['snippet']['title'];
    }

    /*
     * Get Video Id
     */
    public function getVideoId($item)
    {

        return $item['snippet']['resourceId']['videoId'];
    }

    /*
     * Get Video Description
     */
    public function getDescription($item)
    {

        return $item['snippet']['description'];
    }

    /*
     * Get Video PublishedAt
     */
    public function getPublishedAt($item)
    {

        return $item['snippet']['publishedAt'];
    }

    /*
     * Get Video Thumbnail Url
     * If size is null, we return the highest valid size
     * Valid Size : default, medium, high, standard, maxres
     */
    public function getThumbnail($item, $size = null)
    {


        if ($size) {
            if (isset($item['snippet']['thumbnails'][$size])) {
                return $item['snippet']['thumbnails'][$size];
            } else {
                throw new \Exception('Undefined size ' . $size);
            }
        } else {
            if (isset($item['snippet']['thumbnails']['standard'])) {
                return $item['snippet']['thumbnails']['standard']['url'];
            } elseif (isset($item['snippet']['thumbnails']['maxres'])) {
                return $item['snippet']['thumbnails']['maxres']['url'];
            } elseif (isset($item['snippet']['thumbnails']['medium'])) {
                return $item['snippet']['thumbnails']['medium']['url'];
            } elseif (isset($item['snippet']['thumbnails']['default'])) {
                return $item['snippet']['thumbnails']['default']['url'];
            } else {
                throw new \Exception('no Thumbnails');
            }
        }
    }

}
