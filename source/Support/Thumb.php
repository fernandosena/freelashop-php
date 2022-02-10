<?php

namespace Source\Support;

use CoffeeCode\Cropper\Cropper;

/**
 * @package Source\Support
 */
class Thumb
{
    /** @var Cropper */
    private $cropper;

    /**
     * Thumb constructor.
     */
    public function __construct()
    {
        $this->cropper = new Cropper(CONF_IMAGE_CACHE, CONF_IMAGE_QUALITY['jpg'], CONF_IMAGE_QUALITY['png']);
    }

    /**
     * @param string $image
     * @param int $width
     * @param int|null $height
     * @return string
     */
    public function make(string $image, int $width, ?int $height = null): string
    {
        return $this->cropper->make("{$image}", $width, $height);
    }

    /**
     * @param string|null $image
     */
    public function flush(?string $image = null): void
    {
        if ($image) {
            $this->cropper->flush("{$image}");
            return;
        }

        $this->cropper->flush();
        return;
    }

    /**
     * @return Cropper
     */
    public function cropper(): Cropper
    {
        return $this->cropper;
    }
}