<?php

/**
 * This file is part of the Tmdb PHP API created by Michael Roterman.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Tmdb
 * @author Michael Roterman <michael@wtfz.net>
 * @copyright (c) 2013, Michael Roterman
 * @version 4.0.0
 */

namespace Tmdb\Factory\Common;

use Tmdb\Factory\AbstractFactory;
use Tmdb\Model\AbstractModel;
use Tmdb\Model\Collection\Videos;
use Tmdb\Model\Common\Video;

/**
 * Class VideoFactory
 * @package Tmdb\Factory\Common
 */
class VideoFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function createCollection(array $data = [])
    {
        $collection = new Videos();

        if (array_key_exists('videos', $data)) {
            $data = $data['videos'];
        }

        if (array_key_exists('results', $data)) {
            $data = $data['results'];
        }

        foreach ($data as $item) {
            $collection->add(null, $this->create($item));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     *
     * @return AbstractModel|null
     */
    public function create(array $data = []): ?AbstractModel
    {
        $videoType = $this->resolveVideoType($data);

        return (null === $videoType) ? null : $this->hydrate($videoType, $data);
    }

    /**
     * @return Video|null
     */
    private function resolveVideoType(array $data)
    {
        if (array_key_exists('site', $data) && !empty($data['site'])) {
            $site = strtolower($data['site']);

            switch ($site) {
                case 'youtube':
                    return new Video\Youtube();
                default:
                    return new Video();
            }
        }

        return null;
    }
}
