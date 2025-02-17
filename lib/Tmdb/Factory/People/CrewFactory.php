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
use Tmdb\Model\Collection\People\Crew;
use Tmdb\Model\Person\CrewMember;

/**
 * Class CrewFactory
 * @package Tmdb\Factory\People
 */
class CrewFactory extends PeopleFactory
{
    /**
     * {@inheritdoc}
     * @param CrewMember|null $person
     */
    public function createCollection(array $data = [], $person = null, $collection = null): Crew
    {
        $collection = new Crew();

        if (is_object($person)) {
            $class = get_class($person);
        } else {
            $class = '\Tmdb\Model\Person\CrewMember';
        }

        foreach ($data as $item) {
            $collection->add(null, $this->create($item, new $class()));
        }

        return $collection;
    }
}
