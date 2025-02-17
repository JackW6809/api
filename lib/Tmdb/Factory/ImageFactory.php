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

use Tmdb\Exception\RuntimeException;
use Tmdb\Model\Collection\Images;
use Tmdb\Model\Image;

/**
 * Class ImageFactory
 * @package Tmdb\Factory
 */
class ImageFactory extends AbstractFactory
{
    /**
     * Create an image instance based on the path and type, e.g.
     *
     * '/xkQ5yWnMjpC2bGmu7GsD66AAoKO.jpg', 'backdrop_path'
     *
     * @param $path
     * @param string $key
     * @return Image|Image\BackdropImage|Image\LogoImage|Image\PosterImage|Image\ProfileImage|Image\StillImage
     */
    public function createFromPath($path, $key)
    {
        return $this->hydrate(
            self::resolveImageType($key),
            ['file_path' => $path]
        );
    }

    /**
     * Helper function to obtain a new object for an image type
     *
     * @param string|null $key
     * @return Image|Image\BackdropImage|Image\LogoImage|Image\PosterImage|Image\ProfileImage|Image\StillImage
     */
    public function resolveImageType($key = null)
    {
        switch ($key) {
            case 'poster':
            case 'posters':
            case 'poster_path':
                $object = new Image\PosterImage();
                break;

            case 'backdrop':
            case 'backdrops':
            case 'backdrop_path':
                $object = new Image\BackdropImage();
                break;

            case 'profile':
            case 'profiles':
            case 'profile_path':
                $object = new Image\ProfileImage();
                break;

            case 'logo':
            case 'logos':
            case 'logo_path':
                $object = new Image\LogoImage();
                break;

            case 'still':
            case 'stills':
            case 'still_path':
                $object = new Image\StillImage();
                break;

            case 'file_path':
            default:
                $object = new Image();
                break;
        }

        return $object;
    }

    /**
     * Create an Media/Image type which is used in calls like person/tagged_images, which contains an getMedia()
     * reference either referring to movies / tv shows etc.
     *
     * @param array $data
     * @return Image
     *
     * @throws \RuntimeException
     */
    public function createMediaImage(array $data = []): Image
    {
        $type = $this->resolveImageType(array_key_exists('image_type', $data) ? $data['image_type'] : null);
        $image = $this->hydrate($type, $data);

        assert($image instanceof Image);

        if (array_key_exists('media', $data) && array_key_exists('media_type', $data)) {
            switch ($data['media_type']) {
                case "movie":
                    $factory = new MovieFactory($this->getHttpClient());
                    break;

                case "tv":
                    $factory = new TvFactory($this->getHttpClient());
                    break;

                case "season":
                    $factory = new TvSeasonFactory($this->getHttpClient());
                    break;

                // I don't think this ever occurs, but just in case..
                case "episode":
                    $factory = new TvEpisodeFactory($this->getHttpClient());
                    break;

                // I don't think this ever occurs, but just in case..
                case "person":
                    $factory = new PeopleFactory($this->getHttpClient());
                    break;

                default:
                    throw new RuntimeException(sprintf(
                        'Unrecognized media_type "%s" for method "%s::%s".',
                        $data['media_type'],
                        __CLASS__,
                        __METHOD__
                    ));
            }

            $media = $factory->create($data['media']);

            $image->setMedia($media);
        }

        return $image;
    }

    /**
     * Create generic collection
     *
     * @param array $data
     * @return Images
     */
    public function createCollection(array $data = []): Images
    {
        $collection = new Images();

        foreach ($data as $item) {
            $collection->add(null, $this->create($item));
        }

        return $collection;
    }

    /**
     * Convert an array to an hydrated object
     *
     * @param array $data
     * @param string|null $key
     * @return Image
     */
    public function create(array $data = [], $key = null): Image
    {
        $type = self::resolveImageType($key);

        return $this->hydrate($type, $data);
    }

    /**
     * Create full movie collection
     *
     * @param array $data
     * @return Images
     */
    public function createCollectionFromMovie(array $data = [])
    {
        return $this->createImageCollection($data);
    }

    /**
     * Create full collection
     *
     * @param array $data
     * @return Images
     */
    public function createImageCollection(array $data = [])
    {
        $collection = new Images();

        foreach ($data as $format => $formatCollection) {
            if (!is_array($formatCollection)) {
                continue;
            }

            foreach ($formatCollection as $item) {
                if (array_key_exists($format, Image::$formats)) {
                    $item = $this->create($item, $format);

                    $collection->addImage($item);
                }
            }
        }

        return $collection;
    }

    /**
     * Create full tv show collection
     *
     * @param array $data
     * @return Images
     */
    public function createCollectionFromTv(array $data = [])
    {
        return $this->createImageCollection($data);
    }

    /**
     * Create full tv season collection
     *
     * @param array $data
     * @return Images
     */
    public function createCollectionFromTvSeason(array $data = [])
    {
        return $this->createImageCollection($data);
    }

    /**
     * Create full tv episode collection
     *
     * @param array $data
     * @return Images
     */
    public function createCollectionFromTvEpisode(array $data = [])
    {
        return $this->createImageCollection($data);
    }

    /**
     * Create full people collection
     *
     * @param array $data
     * @return Images
     */
    public function createCollectionFromPeople(array $data = [])
    {
        return $this->createImageCollection($data);
    }
}
