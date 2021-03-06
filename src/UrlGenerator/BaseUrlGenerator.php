<?php

namespace Spatie\MediaLibrary\UrlGenerator;

use Illuminate\Contracts\Config\Repository as Config;
use Spatie\MediaLibrary\Conversion\Conversion;
use Spatie\MediaLibrary\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

abstract class BaseUrlGenerator implements UrlGenerator
{
    /**
     * @var \Spatie\MediaLibrary\Media
     */
    protected $media;

    /**
     * @var \Spatie\MediaLibrary\Conversion\Conversion
     */
    protected $conversion;

    /**
     * @var \Spatie\MediaLibrary\PathGenerator\PathGenerator
     */
    protected $pathGenerator;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Spatie\MediaLibrary\Media $media
     *
     * @return \Spatie\MediaLibrary\UrlGenerator\UrlGenerator
     */
    public function setMedia(Media $media) : UrlGenerator
    {
        $this->media = $media;

        return $this;
    }

    /**
     * @param \Spatie\MediaLibrary\Conversion\Conversion $conversion
     *
     * @return \Spatie\MediaLibrary\UrlGenerator\UrlGenerator
     */
    public function setConversion(Conversion $conversion) : UrlGenerator
    {
        $this->conversion = $conversion;

        return $this;
    }

    /**
     * @param \Spatie\MediaLibrary\PathGenerator\PathGenerator $pathGenerator
     *
     * @return \Spatie\MediaLibrary\UrlGenerator\UrlGenerator
     */
    public function setPathGenerator(PathGenerator $pathGenerator) : UrlGenerator
    {
        $this->pathGenerator = $pathGenerator;

        return $this;
    }

    /*
     * Get the path to the requested file relative to the root of the media directory.
     */
    public function getPathRelativeToRoot() : string
    {
        if (is_null($this->conversion)) {
            return $this->pathGenerator->getPath($this->media).urlencode($this->media->file_name);
        }

        return $this->pathGenerator->getPathForConversions($this->media)
        .$this->conversion->getName()
        .'.'
        .$this->conversion->getResultExtension($this->media->extension);
    }
}
