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
 * @version 0.0.1
 */
namespace Tmdb\Model\Movie;

use Tmdb\Model\AbstractModel;
use Tmdb\Model\Filter\CountryFilter;

class Release extends AbstractModel implements CountryFilter {

    private $iso31661;
    private $certification;
    private $releaseDate;

    public static $_properties = array(
        'iso_3166_1',
        'certification',
        'release_date'
    );

    /**
     * @param mixed $certification
     * @return $this
     */
    public function setCertification($certification)
    {
        $this->certification = $certification;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCertification()
    {
        return $this->certification;
    }

    /**
     * @param mixed $iso31661
     * @return $this
     */
    public function setIso31661($iso31661)
    {
        $this->iso31661 = $iso31661;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIso31661()
    {
        return $this->iso31661;
    }

    /**
     * @param mixed $releaseDate
     * @return $this
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = new \DateTime($releaseDate);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }


}