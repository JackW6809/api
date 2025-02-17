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

namespace Tmdb\Factory\People;

use Tmdb\Factory\PeopleFactory;
use Tmdb\Model\Collection\People\GuestStars;
use Tmdb\Model\Person\CastMember;

/**
 * Class GuestStarFactory
 * @package Tmdb\Factory\People
 */
class GuestStarFactory extends PeopleFactory
{
    /**
     * {@inheritdoc}
     * @param CastMember|null $person
     */
    public function createCollection(array $data = [], $person = null, $collection = null): GuestStars
    {
        $collection = new GuestStars();

        if (is_object($person)) {
            $class = get_class($person);
        } else {
            $class = '\Tmdb\Model\Person\GuestStar';
        }

        foreach ($data as $item) {
            $collection->add(null, $this->create($item, new $class()));
        }

        return $collection;
    }
}
