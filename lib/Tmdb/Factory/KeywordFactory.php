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

namespace Tmdb\Factory;

use Tmdb\Model\Collection\Keywords;
use Tmdb\Model\Keyword;

/**
 * Class KeywordFactory
 * @package Tmdb\Factory
 */
class KeywordFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function createCollection(array $data = []): Keywords
    {
        $collection = new Keywords();

        if (array_key_exists('keywords', $data)) {
            $data = $data['keywords'];
        }

        foreach ($data as $item) {
            $collection->addKeyword($this->create($item));
        }

        return $collection;
    }

    /**
     * @param array $data
     *
     * @return Keyword
     */
    public function create(array $data = []): Keyword
    {
        return $this->hydrate(new Keyword(), $data);
    }
}
