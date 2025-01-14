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
use Tmdb\Model\Common\Change;
use Tmdb\Model\Common\GenericCollection;

/**
 * Class ChangeFactory
 * @package Tmdb\Factory\Common
 */
class ChangeFactory extends AbstractFactory
{
    /**
     * {@inheritdoc}
     */
    public function createCollection(array $data = []): GenericCollection
    {
        $collection = new GenericCollection();

        if (array_key_exists('changes', $data)) {
            $data = $data['changes'];
        }

        foreach ($data as $item) {
            $collection->add(null, $this->create($item));
        }

        return $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $data = []): Change
    {
        $change = new Change();

        if (array_key_exists('items', $data)) {
            $items = new GenericCollection();

            foreach ($data['items'] as $item) {
                $item = $this->createChangeItem($item);

                $items->add(null, $item);
            }

            $change->setItems($items);
        }

        return $this->hydrate($change, $data);
    }

    /**
     * Create individual change items
     *
     * @param array $data
     * @return Change\Item
     */
    private function createChangeItem(array $data = []): Change\Item
    {
        return $this->hydrate(new Change\Item(), $data);
    }
}
